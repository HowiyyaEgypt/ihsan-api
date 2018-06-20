<?php

namespace App\Listeners\Feed;

use App\Events\Delivery\NewMealWasReceivedByVolunteer;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateMealWasReceivedByVolunteerFeed
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
     * @param  NewMealWasReceivedByVolunteer  $event
     * @return void
     */
    public function handle(NewMealWasReceivedByVolunteer $event)
    {
        //
    }
}
