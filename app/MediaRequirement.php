<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MediaRequirement extends Model
{
    protected $guarded = [];

    
    public function requireable(){
        return $this->morphTo();
    }

    public function media(){
        return $this->hasMany('App\Media');
    }
}
