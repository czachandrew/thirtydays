<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
	public $with = ['creator'];

	protected $guarded =[];
    //
	public function workouts(){
		return $this->belongsToMany('App\Workout')->withPivot('order');
	}

	public function coach(){
		return $this->hasMany('App\User', 'coach_id');
	}

	public function creator(){
		return $this->belongsTo('App\User', 'creator_id');
	}

	public function participants(){
		return $this->belongsToMany('App\User', 'challenge_user', 'challenge_id', 'user_id');
	}

	public function comments(){
		return $this->morphToMany('App\Comment', 'commentable');
	}

	public function start(){
		$this->status = 'active'; 
		$this->current_day = 1;
		$this->save();
		Events\ChallengeHasStarted::dispatch($this);

		return $this;
	}

	public function today(){
		return $this->days()->where('order', $this->current_day)->with(['submissions.user','submissions.bumps', 'workout'])->first();
	}

	public function createDays(){
		$i = 1; 
		do {
			$this->days()->save(new ChallengeDay(['challenge_id' => $this->id, 'order' => $i]));
			$i++;
		}
		while($i <= 30);
	}

	public function addDay($data){
		$this->days()->save($data);
		return $this;

	}

	public function days(){
		return $this->hasMany('App\ChallengeDay');
	}

}
