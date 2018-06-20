<?php

namespace App\Listeners\Delivery;

use App\Events\Delivery\NewMealWasDelivered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMealWasDeliveredNotification
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
     * @param  NewMealWasDelivered  $event
     * @return void
     */
    public function handle(NewMealWasDelivered $event)
    {
        //
    }
}
