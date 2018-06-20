<?php

namespace App\Listeners\Feed;

use App\Events\Kitchen\NewKitchenWasOpened;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Feed;

class CreateNewKitchenOpenedFeed
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
     * @param  NewKitchenWasOpened  $event
     * @return void
     */
    public function handle(NewKitchenWasOpened $event)
    {
        Feed::Create([
            'feedable_type' => 'App\Organization',
            'feedable_id' => $event->kitchen->organization->id,
            'full_message' => [
                'body' => [

                    'ar' => trans('feed.kitchen.new_kitchen_opened',[
                        'organization' => $event->kitchen->organization->name,
                        'city' => $event->kitchen->location->city->name_ar
                    ],'ar'),

                    'en' => trans('feed.kitchen.new_kitchen_opened',[
                        'organization' => $event->kitchen->organization->name,
                        'city' => $event->kitchen->location->city->name_en
                    ],'en'),
                ]
            ]
        ]);
    }
}
