<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $guarded = [];

    protected $with = ['requirement'];

    public function mediable(){
        return $this->morphTo();
    }

    public function requirement(){
        return $this->belongsTo('App\MediaRequirement');
    }

}
