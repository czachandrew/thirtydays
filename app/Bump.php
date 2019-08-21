<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bump extends Model
{
    //

	protected $guarded = [];
	
	public function user(){
		return $this->belongsTo('App\User');
	}

	public function submission(){
		return $this->belongsTo('App\Submission');
	}
}
