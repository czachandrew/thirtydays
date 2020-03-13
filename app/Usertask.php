<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Usertask extends Model
{
    protected $guarded = [];

    public function task(){
        return $this->belongsTo('App\Task');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function group(){
        return $this->belongsTo('App\Zonegroup');
    }

    public function scopeUnapproved($query){
        return $query->where('status', 'new');
    }

    public function approve(){
        $this->status = 'approved';
        $this->save();
        return $this;
    }

    public function media(){
        return $this->morphMany('App\Media', 'mediable');
    }
}
