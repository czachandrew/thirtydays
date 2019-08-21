<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Challenge;
use Log;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

        // $this->middleware('subscribed');

        // $this->middleware('verified');
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function show()
    {
        //get the current logged in user
        $user = Auth::user()->load(['created_challenges' ,'challenges']);
        $recently_made = Challenge::where('status', 'open')->limit(10)->with('participants')->get();
        //Log::info(\Auth::user());
        //$user->load('challenges');
        $challenges = Challenge::all();
        return view('home', compact(['user', 'challenge', 'recently_made']));
    }
}
