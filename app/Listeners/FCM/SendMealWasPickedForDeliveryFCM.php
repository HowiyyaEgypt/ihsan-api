<?php

namespace App\Listeners\FCM;

use App\Events\Delivery\NewMealWasPickedForDelivery;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMealWasPickedForDeliveryFCM
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
     * @param  NewMealWasPickedForDelivery  $event
     * @return void
     */
    public function handle(NewMealWasPickedForDelivery $event)
    {
        //
    }
}
