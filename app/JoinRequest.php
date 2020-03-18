<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JoinRequest extends Model
{
    protected $guarded = [];

    protected $with = ['user'];

    public function user(){
        return $this->belongsTo('App\User')->select(['id', 'name', 'email']);
    }

    public function kratespace(){
        return $this->belongsTo('App\Kratespace');
    }

}
