<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Carbon\Carbon;
use App\Property;
use App\Week;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        $loginView = view('auth.login');

        $property = Property::inRandomOrder()->first();
        if($property){
            $weeks = $property->weeks()->whereHas('auction', function ($query) {
                $query->whereNull('deleted_at')->where('inscripcion_fin', '>=', Carbon::now());
            })->count();
            $loginView->with(
                [
                    'p' => $property,
                    'weeks' => $weeks,
                ]
            );
        }

        $week = Week::has('auction')->inRandomOrder()->first();
        if($week){
            $loginView->with('w', $week);
        }

        return $loginView;
    }
}
