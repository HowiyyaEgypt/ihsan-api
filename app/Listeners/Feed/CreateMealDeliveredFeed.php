<?php

namespace App\Listeners\Feed;

use App\Events\Delivery\NewMealWasDelivered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Feed;

class CreateMealDeliveredFeed
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
        Feed::Create([
            'feedable_type' => 'App\User',
            'feedable_id' => $event->meal->users->first()->id,
            'full_message' => [
                'body' => [

                    'ar' => trans('feed.delivery.new_meal_donated',[
                        'kitchen' => $event->delivery->kitchen->name,
                        'username' => $event->user->name
                    ],'ar'),

                    'en' => trans('feed.delivery.new_meal_donated',[
                        'kitchen' => $event->delivery->kitchen->name,
                        'username' => $event->user->name
                    ],'en'),
                ]
            ]
        ]);
    }
}
