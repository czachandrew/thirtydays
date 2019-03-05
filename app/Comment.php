<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
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
}
