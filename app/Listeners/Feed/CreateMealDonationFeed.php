<?php

namespace App\Listeners\Feed;

use App\Events\Meal\NewMealWasDonated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Feed;

class CreateMealDonationFeed
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
        Feed::Create([
            'feedable_type' => 'App\User',
            'feedable_id' => $event->meal->users->first()->id,
            'full_message' => [
                'body' => [

                    'ar' => trans('feed.meal.new_meal_donated',[
                        'kitchen' => $event->meal->kitchen->name,
                        'username' => $event->user->name
                    ],'ar'),

                    'en' => trans('feed.meal.new_meal_donated',[
                        'kitchen' => $event->meal->kitchen->name,
                        'username' => $event->user->name
                    ],'en'),
                ]
            ]
        ]);
    }
}
