<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \App\Reward;
use Carbon\Carbon;
use Log;


class Progression extends Model
{
    //attributes
	private $protected = [];
	/**
	* Attributes user_id, level, lifteime_xp, current_xp, redeemed_xp, gifts, next_level 
	*/
	
	public function user(){
		return $this->belongsTo('App\User'); 
	}

	public function rewards(){
		return $this->belongsToMany('App\Reward');
	}

	public function boxes(){
		return $this->hasMany('App\Box');
	}

	public function awardExperience($points){
		$this->increment('current_xp', $points);
		$this->increment('lifetime_xp', $points);

		Events\UserEarnedExperience::dispatch($this->user, ['current' => $this->current_xp, 'increment' => $points, 'progression' => $this]);
		// Here this should really be an even not just directly tied to the code
		//broadcast that experience has been rewarded
		// if($this->lifetime_xp >= $this->next_level) {
		// 	$this->levelUp(1);
		// 	$this->next_level = 500;
		// }

		return $this;
	}

	public function buyBox($points, $boxtype){
		$this->decrement('current_xp', $points);
		$this->increment('redeemed_xp', $points);
		//here is where we should create the box/user relationship instead of just incrementing gifts
		$this->increment('gifts', 1);
		return $this;
	}

	public function buyKrate($krate){
		$this->decrement('current_xp', $krate->cost); 
		$this->increment('redeemed_xp', $krate->cost);
		//generate a unique hash for this krate
		$hash = md5(Carbon::now() . $this->user->id);
		$this->user->krates()->create(['user_id' => $this->user->id, 'krate_id' => $krate->id,'hash' => $hash]);
		return $this;
	}

	public function openBox($roll){
		//get a random reward based on the roll
		if($roll >= 97){
			
			$this->user->rewards()->attach(Reward::find(1), [
				'status' => 'active']);
		} else if($roll >= 60 && $roll < 97) {
			$keys = [2,3,4];
			$reward = Reward::find($keys[array_rand($keys)]);
			Log::info($reward);
			$this->user->rewards()->attach($reward, ['status' => 'active']);
		} else {
			$reward = Reward::find(5);
			$this->user->rewards()->attach($reward, ['status' => 'active']);
		}

		$this->decrement('gifts', 1);



		return $this;
	}

	public function spendExperience($points){
		$this->current_xp -= $points; 
		$this->increment('redeemed_xp', $points);

		return $this;
	}

	public function  awardGift() {
		$this->gifts--;
		return $this;
	}

	public function levelUp($level){
		$this->increment('level', $level); 
		return $this;
	}

	public function experienceEvents(){
		return $this->hasMany('App\ExperienceEvent');
	}

}
