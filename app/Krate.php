<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Krate extends Model
{
    //
    protected $guarded = [];

    public function kratespace(){
        return $this->belongsTo('App\Kratespace');
    }
}
