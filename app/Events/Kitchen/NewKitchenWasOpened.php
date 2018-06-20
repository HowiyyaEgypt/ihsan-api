<?php

namespace App\Events\Kitchen;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Kitchen;
use App\User;

class NewKitchenWasOpened
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $kitchen;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, Kitchen $kitchen)
    {
        $this->user = $user;
        $this->kitchen = $kitchen;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
