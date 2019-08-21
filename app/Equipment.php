<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $fillable = ['title', 'image']; 

    public function exercise(){
    	$this->belongsToMany('App\Exercise');
    }

}
