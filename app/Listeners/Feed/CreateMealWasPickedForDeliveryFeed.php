<?php

namespace App\Listeners\Feed;

use App\Events\Delivery\NewMealWasPickedForDelivery;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Feed;

class CreateMealWasPickedForDeliveryFeed
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
        Feed::Create([
            'feedable_type' => 'App\User',
            'feedable_id' => $event->delivery->users->first()->id,
            'full_message' => [
                'body' => [

                    'ar' => trans('feed.delivery.volunteer_picked_meal',[
                        'kitchen' => $event->delivery->kitchen->name,
                        'username' => $event->user->name
                    ],'ar'),

                    'en' => trans('feed.delivery.volunteer_picked_meal',[
                        'kitchen' => $event->delivery->kitchen->name,
                        'username' => $event->user->name
                    ],'en'),
                ]
            ]
        ]);
    }
}
