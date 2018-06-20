<?php

namespace App\Events\Delivery;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\User;
use App\Delivery;

class NewMealWasPickedForDelivery
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $delivery;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, Delivery $delivery)
    {
        $this->user = $user;
        $this->delivery = $delivery;
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
