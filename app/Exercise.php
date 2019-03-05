<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    //
	public function workout(){
		return $this->belongsToMany('App\Workout');
	}
}
