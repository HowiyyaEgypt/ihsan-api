<?php

namespace App\Listeners\Kitchen;

use App\Events\Kitchen\KitchenWasClosed;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendKitchenClosedNotification
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
     * @param  KitchenWasClosed  $event
     * @return void
     */
    public function handle(KitchenWasClosed $event)
    {
        //
    }
}
