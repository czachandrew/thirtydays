<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //
    protected $guarded = [];

    protected $with = ['media_requirements'];

    public function group(){
        return $this->belongsTo('App\Zonegroup');
    }

    public function increment_count(){
        return $this->count++;
    }

    public function incrementCount(){
        return $this->count++;
    }

    public function suspend(){
        $this->status = 'suspended';
        return $this;
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function usertasks(){
        return $this->hasMany('App\Usertask');
    }

    public function media(){
        return $this->morphMany('App\Media', 'mediable');
    }

    public function media_requirements(){
        return $this->morphMany('App\MediaRequirement', 'requireable');
    }

    public function addRequirement($requirement){
        $this->media_requirements()->create($requirement);
    }



}
