<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zonegroup extends Model
{
    protected $guarded = [];

    public function kratespace(){
        return $this->belongsTo('App\Kratespace');
    }

    public function users(){
        return $this->belongsToMany('App\User', 'user_zonegroup');
    }

    public function tasks(){
        return $this->hasMany('App\Task'); 
    }

    public function submissions(){
        return $this->hasMany('App\Submission');
    }

    public function media(){
        return $this->morphMany('App\Media', 'mediable');
    }
}
