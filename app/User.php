<?php

namespace App;

use Laravel\Spark\User as SparkUser;
use Laravel\Passport\HasApiTokens;
use Hootlex\Friendships\Traits\Friendable;

class User extends SparkUser
{

    use HasApiTokens, Friendable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'authy_id',
        'country_code',
        'phone',
        'two_factor_reset_code',
        'card_brand',
        'card_last_four',
        'card_country',
        'billing_address',
        'billing_address_line_2',
        'billing_city',
        'billing_zip',
        'billing_country',
        'extra_billing_information',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'trial_ends_at' => 'datetime',
        'uses_two_factor_auth' => 'boolean',
    ];

    public function is_coaching(){
        return $this->belongsToMany('App\Challenge','challenge_coach', 'coach_id', 'challenge_id');
    }

    public function created_challenges(){
        return $this->hasMany('App\Challenge', 'creator_id');
    }

    public function challenges(){
        return $this->belongsToMany('App\Challenge', 'challenge_user', 'user_id', 'challenge_id');
    }

    public function submissions(){
        return $this->hasMany('App\Submission');
    }

    public function progression(){
        return $this->hasOne('App\Progression');
    }

    public function rewards(){
        return $this->belongsToMany('App\Reward', 'user_reward', 'user_id', 'reward_id')->wherePivot('status', 'active')->withPivot('id', 'status');
    }

    public function redeemReward($reward){
        $this->user->rewards()->updateExistingPivot($reward, ['status' => 'done', 'redeemed' => 1]);

        return $this;
    }

    public function bumps(){
        return $this->hasMany('App\Bump');
    }

    public function comments(){
        return $this->hasMany('App\Comment');
    }

    public function providedRewards(){
        return $this->hasMany('App\Reward', 'provider_id');
    }

    public function krates(){
        return $this->hasMany('App\UserKrate')->with('krate');
    }

    public function openableKrates(){
        return $this->hasMany('App\UserKrate')->where('status', 'unopened')->with('krate');
    }

    public function latestKrate(){
        return $this->hasMany('App\UserKrate')->with('krate')->latest()->limit(1);
    }

    // ngrok http -subdomain=andogrando -host-header=rewrite thirtydays.test:80










}
