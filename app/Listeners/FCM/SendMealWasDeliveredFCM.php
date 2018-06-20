<?php

namespace App\Listeners\FCM;

use App\Events\Delivery\NewMealWasDelivered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMealWasDeliveredFCM
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
