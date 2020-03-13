<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExperienceEvent extends Model
{
    protected $guarded = [];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function progression(){
        return $this->belongsTo('App\Progression');
    }

    public function kratespace(){
        return $this->belongsTo('App\Kratespace');
    }
}
