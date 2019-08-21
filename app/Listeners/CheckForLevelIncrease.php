<?php

namespace App\Listeners;

use App\Events\UserEarnedExperience;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
use App\Prgression;

class CheckForLevelIncrease
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  =UserEarnedExperience  $event
     * @return void
     */
    public function handle(UserEarnedExperience $event)
    {
        $user = $event->user;
        //print($event->user);
        //die($event->user);
        $user->load('progression');
        //print($user->progression->lifetime_xp . " ?=? " . $user->progression->next_level);
        if($user->progression->lifetime_xp >= $user->progression->next_level){
            //update the level
            //print("Level up!");
            //update the next level 
            $user->progression->level += 1;
            $user->progression->next_level = $user->progression->next_level * 1.5; 
            $user->progression->save(); 
            //announce that a user has a leveled up
            //print("This is in the event listener");
            //print($user);
            //return true;
        } else {
            //return false;
        }
    }
}
