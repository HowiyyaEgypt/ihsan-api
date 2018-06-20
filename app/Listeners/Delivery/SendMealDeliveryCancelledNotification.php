<?php

namespace App\Listeners\Delivery;

use App\Events\Delivery\MealDeliveryWasCancelled;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMealDeliveryCancelledNotification
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
