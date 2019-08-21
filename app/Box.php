<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Box extends Model
{
    //

	private $protected = []; 

	public function progression(){
		return $this->belongsTo('App\Progression');
	}

}
