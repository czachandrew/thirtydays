<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    //
	protected $guarded = [];

	public function workout(){
		return $this->belongsTo('App\Workout');
	}

	public function challengeday(){
		return $this->belongsToMany('App\ChallengeDay', 'challengeday_submissions','submission_id');
	}

	public function user(){
		return $this->belongsTo('App\User');
	}

	public function comments(){
		return $this->morphToMany('App\Comment', 'commentable');
	}

	public function bump($userId){
		return $this->bumps()->save(new Bump(['user_id' => $userId]));
	}

	public function addComment($comment){
		return $this->comments()->create($comment);
	}

	public function bumps(){
		return $this->hasMany('App\Bump');
	}
}
