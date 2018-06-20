<?php

namespace App\Listeners\FCM;

use App\Events\Meal\NewMealWasDonated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMealWasDonatedFCM
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
     * @param  NewMealWasDonated  $event
     * @return void
     */
    public function handle(NewMealWasDonated $event)
    {
        //
    }
}
