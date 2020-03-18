<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Log;

class Reward extends Model
{
    protected $guarded = [];

    public function user(){
    	return $this->belongsToMany('App\Reward', 'user_reward', 'reward_id', 'user_id');
    }

    public function awardTo(User $user) {
        Log::info($user);
    	$this->user()->attach($user); 
        $this->stock--; 	

    	return $this;
    }

    public function provider(){
    	return $this->belongsTo('App\User', 'provider_id');
    }

    public function addStock($interval){
    	return $this->stock += $interval; 
    }

    public function scopeAvailable($query){
        return $query->where('status', 'active')->where('stock', '>', 0);
    }

    public function media(){
        return $this->morphMany('App\Media', 'mediable');
    }

    


}
