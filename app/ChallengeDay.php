<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Submission;

class ChallengeDay extends Model
{
    protected $guarded = [];

    public function challenge(){
    	return $this->belongsTo('App\Challenge');
    }

    public function workout(){
    	return $this->belongsTo('App\Workout');
    }

    public function submissions(){
    	return $this->belongsToMany('App\Submission', 'challengeday_submissions', 'challengeday_id');

    }

    public function comments(){
        return $this->morphToMany('App\Comment', 'commentable');
    }

    public function addComment($comment){
        return $this->comments()->create($comment);
    }

    public function addSubmission($score){
        //workout_id challenge_id user_id image type description time score completed
        $submission = new Submission($score);
        $this->submissions()->save($submission);
        return $submission;
    }
}
