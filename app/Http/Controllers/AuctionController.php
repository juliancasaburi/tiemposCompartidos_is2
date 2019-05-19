<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Auction;
use Auth;

class AuctionController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $auction = Auction::where('id', Request()->id)
            ->get()->first();

        // If auction id doesn't exist, show 404 error page
        if(empty($auction)) {
            abort(404);
        }

        $latestBid = $auction->latestBid->first();

        if(Auth::user()) {
            $myLatestBid = $auction->latestBidForUser(Auth::user());
            // Return view
            return view('auction', [
                'auction' => $auction,
                'latestBid' => $latestBid,
                'myLatestBid' => $myLatestBid,
            ]);
        }

        // Return view
        return view('auction', [
            'auction' => $auction,
            'latestBid' => $latestBid,
        ]);
    }
}