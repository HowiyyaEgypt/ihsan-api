<?php

namespace App\Events\Meal;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\User;
use App\Meal;

class NewMealWasDonated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $meal;
    public $mode;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, Meal $meal, $mode)
    {
        $this->user = $user;
        $this->meal = $meal;
        $this->mode = $mode;
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
