<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UsertaskApproved implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userId; 
    public $usertaskId;
    public $xp;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($userId, $usertaskId, $xp)
    {
        $this->userId = $userId; 
        $this->usertaskId = $usertaskId;
        $this->xp = $xp; 
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('user-channel-' . $this->userId);
    }

    public function broadcastAs(){
        return 'usertask-approved';
    }
}
