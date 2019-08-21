<?php

namespace App\Listeners;

use App\Events\ChallengeHasStarted;
use App\Notifications\ChallengeBegun;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyUsersOfChallengeStart
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
     * @param  ChallengeHasStarted  $event
     * @return void
     */
    public function handle(ChallengeHasStarted $event)
    {
        $challenge = $event->challenge->load("participants");

        foreach($challenge->participants as $user) {
            $user->notify(new ChallengeBegun($challenge));
        }
    }
}
