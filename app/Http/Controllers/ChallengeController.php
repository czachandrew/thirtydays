<?php

namespace App\Http\Controllers;

use App\Challenge;
use Illuminate\Http\Request;
use Log;
use Auth;
use Carbon\Carbon;
use App\ChallengeDay;

class ChallengeController extends Controller
{

    public function __construct(){
        $this->middleware('auth:api');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $challenges = Challenge::all();
        return view('challenges.index', compact('challenges'));

    }

    /** 
     * Add a ChallengeDay to an Existing Challenge.
     * 
     * @return \bool for success
     */

     public function addDay(Challenge $challenge) {

        $challenge->addDay(request('day'));

     }


    public function getChallenges(){
        $user = Auth::user();
        $challenges = Challenge::all();
        return $challenges;
    }

    public function myChallenges(){
        $user = Auth::user();
        $myChallenges = $user->challenges()->where('status', 'active')->get();
        return $myChallenges;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('challenges.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate the request 
        $attributes = $request->validate(['title' => 'required', 'description' => 'required', 'image' => '']);
        $attributes['creator_id'] = Auth::user()->id;

        $challenge = Challenge::create($attributes);

        //should I create the 30 day records here? 
        $challenge->createDays();
        //redirect the coach to the dashboard
        return redirect('/challenges/' . $challenge->id);
        //if api return the created item
    }

    /**
    * Start a challenge effectively closing to members who wish to join late 
    * in some cases
    * validate that a start date is set (end dates will be computed)
    * @param \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response
    */
    public function start(Challenge $challenge){
        //validate that a challenge has a start date 
        // $challenge->status = 'active';
        // $challenge->current_day = 1;
        // $challenge->save();
        $challenge->start();
        //Announce to the applicatio that this challenge has been started 
        //event(new ChallengeHasStarted($challenge));
        //send a notification to all the users 
        return $challenge; 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Challenge  $challenge
     * @return \Illuminate\Http\Response
     */
    public function show(Challenge $challenge)
    {
        $user = Auth::user();
        $challenge->load(['days.workout','days.submissions.bumps', 'workouts', 'participants']);
        return view('challenges.show', compact('user','challenge'));
    }

    public function showUserChallengeView(Challenge $challenge) {
        //what they need to see
        //today's workout, who's done and their score, who hasn't gone yet,
        $today = $challenge->today();
        return view('challenges.today', compact(['challenge', 'today']));
    }

    public function addScore(ChallengeDay $challengeday){
        $score = request('score');
        $user = Auth::user();
        $score['user_id'] = $user->id;
        $submission = $challengeday->addSubmission($score);
        $submission->load(['user','bumps']);
        $challengeday->save();
        $challengeday->load(['submissions.user','submissions.bumps']);
        return $submission;

    }


    public function scheduleStart(Challenge $challenge, ChallengeDay $challengeday){
        $challenge->start_date = Carbon::parse(request('date'));
        $open = request('open');
        if($open === true){
            $challenge->status = 'open';
        }
        $challenge->save();
        return $challenge;
    }

    public function joinChallenge(Challenge $challenge){
        $user = Auth::user();
        $challenge->participants()->save($user);
        return $challenge;

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Challenge  $challenge
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Challenge  $challenge
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Challenge $challenge)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Challenge  $challenge
     * @return \Illuminate\Http\Response
     */
    public function destroy(Challenge $challenge)
    {
        //
    }
}
