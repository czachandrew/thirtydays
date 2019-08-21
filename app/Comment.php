<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
	protected $guarded = [];
    //
	public function challenges(){
		return $this->morphedByMany('App\Challenge', 'commentable');
	}

	public function workouts(){
		return $this->morphedByMany('App\Workout', 'commentable');
	}

	public function submissions(){
		return $this->morphedByMany('App\Submission', 'commentable');
	}

	public function day(){
		return $this->morphedByMany('App\ChallengeDay', 'commentable');
	}

	public function user(){
		return $this->belongsTo('App\User');
	}
}
