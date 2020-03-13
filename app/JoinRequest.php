<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JoinRequest extends Model
{
    protected $guarded = [];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function kratespace(){
        return $this->belongsTo('App\Kratespace');
    }

}
