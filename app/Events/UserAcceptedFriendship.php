<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserAcceptedFriendship implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $sender;
    public $friend;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $sender, User $friend)
    {
        $this->sender = $sender;
        $this->friend = $friend;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return ['user.channel.' . $this->sender->id, 'user.channel.' . $this->friend->id];
        //return new PrivateChannel('channel-name');
    }

    public function broadcastAs(){
        return 'new-friendship';
    }
}
