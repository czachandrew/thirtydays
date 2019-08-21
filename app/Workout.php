<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
	protected $guarded = [];
    //
	public function challenge(){
		return $this->belongsToMany('App\Challenge');
	}

	public function order(){
		
	}

	public function days(){
		return $this->belongsToMany('App\ChallengeDay');
	}

	public function submissions(){
		return $this->hasMany('App\Submission');
	}

	public function creator(){
		return $this->belongsTo('App\User');
	}

	public function comments(){
		return $this->morphToMany('App\Comment', 'commentable');
	}

	public function exercises(){
		return $this->belongsToMany('App\Exercise');
	}
}
