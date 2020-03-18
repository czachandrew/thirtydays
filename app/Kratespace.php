<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kratespace extends Model
{
    //name, description, visiblity, status, joinable, link, photo_url, space_xp, krate_xp, 

    //hasmany Admins, Groups, Rewards, Events

    protected $guarded = [];

    protected $with = ['rewards','requests'];

    public function owner(){
        return $this->belongsTo('App\User');
    }

    public function admins(){
        return $this->belongsToMany('App\User', 'admin_space');
    }

    public function groups(){
        return $this->hasMany('App\Zonegroup');
    }

    public function addGroup($group){
        return $this->groups()->create($group);
    }

    public function submissions(){
        return $this->hasManyThrough('App\Submission', 'App\Zonegroup');
    }

    public function users(){
        return $this->belongsToMany('App\User', 'kratespace_user');
    }

    public function rewards(){
        return $this->hasMany('App\Reward', 'provider_id');
    }

    public function krates(){
        return $this->hasMany('App\Krate', 'kratespace_id');
    }

    public function distributeFromBank($number){
        $this->decrement('space_xp', $number);
       //$this->space_xp -= $number;
        return $this;
    }

    public function addToBank($number){
        $this->increment('space_xp', $number);
        //$this->space_xp += $amount; 
        return $this;
    }

    public function requests(){
        return $this->hasMany('App\JoinRequest');
    }

}
