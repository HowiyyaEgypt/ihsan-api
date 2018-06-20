<?php

namespace App\Listeners\FCM;

use App\Events\Delivery\MealDeliveryWasCancelled;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMealDeliveryCancelledFCM
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
     * @param  MealDeliveryWasCancelled  $event
     * @return void
     */
    public function handle(MealDeliveryWasCancelled $event)
    {
        //
    }
}
