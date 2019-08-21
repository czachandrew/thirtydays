<?php

namespace App\Http\Controllers;

use App\Workout;
use App\Challenge;
use App\ChallengeDay;
use Illuminate\Http\Request;

class WorkoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Challenge $challenge)
    {
        $workoutData = request('workout');
        $videos = request('videos');
        $order = request('order');
        $attach = request('attach');
        $workout = Workout::create($workoutData);
        if($attach === true){
            $challenge->addDay();
        }
        // $challenge = Challenge::find($challengeId);
        // $challenge->workouts()->save($workout, ['order' => $order]);
        return $workout;
    }

    public function getScores(ChallengeDay $challengeday){
        $submissions = $challengeday->workout->submissions->load(['user','bumps']);
        return $submissions;

    }

    public function createWorkoutAndAttach(ChallengeDay $challengeday){
        $workoutData = request('workout');
        $videos = request('videos');
        $order = request('order');
        $attach = request('attach');
        $workout = Workout::create($workoutData);
        $challengeday->workout_id = $workout->id; 
        $challengeday->save();
        $challengeday->load('workout');
        return $challengeday;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Workout  $workout
     * @return \Illuminate\Http\Response
     */
    public function show(Workout $workout)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Workout  $workout
     * @return \Illuminate\Http\Response
     */
    public function edit(Workout $workout)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Workout  $workout
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Workout $workout)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Workout  $workout
     * @return \Illuminate\Http\Response
     */
    public function destroy(Workout $workout)
    {
        //
    }
}
