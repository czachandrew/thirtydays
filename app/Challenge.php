<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    //
	public function workouts(){
		return $this->hasMany('App\Workout');
	}

	public function coach(){
		return $this->hasMany('App\User', 'coach_id');
	}

	public function participants(){
		return $this->belongsToMany('App\User', 'challenge_user', 'challenge_id', 'participant_id');
	}

	public function comments(){
		return $this->morphToMany('App\Comment', 'commentable');
	}

}
