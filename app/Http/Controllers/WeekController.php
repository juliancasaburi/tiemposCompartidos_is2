<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Reservation;
use App\Week;

class WeekController extends Controller
{

    /**
     * Show a week.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $week = Week::where('id', $request->id)
            ->withTrashed()
            ->get()
            ->first();

        // If property id doesn't exist, show 404 error page
        if(empty($week) || !$week->auction) {
            abort(404);
        }

        $reservation = Reservation::where('semana_id', $week->id)->get();
        $enabled = (($reservation->isEmpty()) && ($week->auction->inscripcion_inicio <= Carbon::now()) && ($week->auction->inscripcion_fin > Carbon::now()));

        // Return view
        return view('week', [
            'week' => $week,
            'enabled' => $enabled,
        ]);
    }

    /**
     * Show the week grid.
     *
     * @return \Illuminate\Http\Response
     */
    public function showGrid(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'semanaDesde' => ['required', 'date'],
            'semanaHasta' => ['required', 'date'],
        ]);

        if($validator->fails()){
            // Redirect to home
            return redirect('/');
        }

        $fromWeekStart = Carbon::parse($request->semanaDesde)
            ->startOfWeek()
            ->toDateString();

        $toWeekStart = Carbon::parse($request->semanaHasta)
            ->startOfWeek()
            ->toDateString();

        $weeks = Week::whereBetween('fecha', [$fromWeekStart, $toWeekStart ])
            ->whereNull('deleted_at')
            ->whereHas('auction', function ($query) {
                $query->where('inscripcion_inicio', '<=', Carbon::now())->where('inscripcion_fin', '>', Carbon::now());
            })
            ->paginate(2)
            ->withPath('?semanaDesde='.$fromWeekStart.'&semanaHasta='.$toWeekStart);

        return view('weeks', [
            'weeks' => $weeks,
        ]);
    }

    public function book(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $user = Auth::user();
        if(!$user->premium){
            // Redirect back and show an error message
            return redirect()
                ->back()
                ->with('alert-error', 'Operacion inválida');
        }
        else{
            $week = Week::find($request->weekID);
            if(($week) && (!$week->reservation) && ($week->auction->inscripcion_inicio <= Carbon::now()) && ($week->auction->inscripcion_fin > Carbon::now())){

                $week->bookTo($user);

                // Redirect back and show a success message
                return redirect()
                    ->back()
                    ->with('alert-success', 'Adjudicada');

            }
            else{
                // Redirect back and show an error message
                return redirect()
                    ->back()
                    ->with('alert-error', 'Operacion inválida');
            }
        }
    }
}