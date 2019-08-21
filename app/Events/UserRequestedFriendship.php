<?php

namespace App\Events;

use App\User;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserRequestedFriendship implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $sender;
    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $sender, User $user)
    {
        $this->sender = $sender;
        $this->user = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return ['user.channel.' . $this->user->id];
    }

    public function broadcastAs(){
        return 'friendship-requested';
    }
}
