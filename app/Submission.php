<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    //
	public function workout(){
		return $this->belongsTo('App\Workout');
	}

	public function user(){
		return $this->belongsTo('App\User');
	}

	public function comments(){
		return $this->morphToMany('App\Comment', 'commentable');
	}
}
