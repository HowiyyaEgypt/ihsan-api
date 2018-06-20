<?php

namespace App\Listeners\FCM;

use App\Events\Delivery\NewMealWasReceivedByVolunteer;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMealWasReceivedByVolunteerFCM
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
