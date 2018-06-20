<?php

namespace App\Listeners\Feed;

use App\Events\Kitchen\KitchenWasClosed;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateKitchenClosedFeed
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
