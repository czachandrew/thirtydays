<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Log;

class UserKrate extends Model
{
    protected $guarded = [];

	public function user(){
		return $this->belongsTo('App\User');
	}

	public function krate(){
		return $this->belongsTo('App\Krate');
	}

	public function open(){
		Log::info('Opening the user krate');
		$this->status = 'opened'; 
		//$this->opened_on = Carbon::today();
		Log::info($this);
		return $this;
	}

	public function scopeGrouped($query){
		return $query->with(['krate' => function ($q){
			$q->select('title', 'description')->groupBy('title');
		}]);
	}
}
