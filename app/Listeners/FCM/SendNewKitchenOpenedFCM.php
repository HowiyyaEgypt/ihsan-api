<?php

namespace App\Listeners\FCM;

use App\Events\Kitchen\NewKitchenWasOpened;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\FcmTrait;

class SendNewKitchenOpenedFCM
{
    use FcmTrait;

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
        $data = [
            'ar' => [
                'title' => 'تم إفتتاح مطبخ جديد',
                'body' => trans('feed.kitchen.new_kitchen_opened',[
                        'organization' => $event->kitchen->organization->name,
                        'city' => $event->kitchen->location->city->name_ar
                        ],'ar')
            ],
            'en' => [
                'title' => 'A new kitchen is opened',
                'body' => trans('feed.kitchen.new_kitchen_opened',[
                        'organization' => $event->kitchen->organization->name,
                        'city' => $event->kitchen->location->city->name_en
                        ],'en') 
            ]
        ];

        // TODO: this is SO WRONG!!
        foreach($event->kitchen->organization->users as $user) {
            $this->sendFcm($user, $data);
        }
    }
}
