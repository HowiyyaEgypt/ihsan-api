<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [

        'App\Events\Kitchen\NewKitchenWasOpened' => [
            'App\Listeners\Kitchen\SendNewKitchenOpenedNotification',
            'App\Listeners\FCM\SendNewKitchenOpenedFCM',
            'App\Listeners\Feed\CreateNewKitchenOpenedFeed',
        ],

        'App\Events\Kitchen\KitchenWasClosed' => [
            'App\Listeners\Kitchen\SendKitchenClosedNotification',
            'App\Listeners\FCM\SendKitchenClosededFCM',
            'App\Listeners\Feed\CreateKitchenClosedFeed',
        ],

        'App\Events\Meal\NewMealWasDonated' => [
            'App\Listeners\Meal\SendMealWasDonatedNotification',
            'App\Listeners\FCM\SendMealWasDonatedFCM',
            'App\Listeners\Feed\CreateMealDonationFeed',
        ],

        'App\Events\Delivery\NewMealWasPickedForDelivery' => [
            'App\Listeners\Delivery\SendMealWasPickedForDeliveryNotification',
            'App\Listeners\FCM\SendMealWasPickedForDeliveryFCM',
            'App\Listeners\Feed\CreateMealWasPickedForDeliveryFeed',
        ],

        'App\Events\Delivery\MealDeliveryWasCancelled' => [
            'App\Listeners\Delivery\SendMealDeliveryCancelledNotification',
            'App\Listeners\FCM\SendMealDeliveryCancelledFCM',
            'App\Listeners\Feed\CreateMealDeliveryCancelledFeed',
        ],

        'App\Events\Delivery\NewMealWasReceivedByVolunteer' => [
            'App\Listeners\Delivery\SendMealWasReceivedByVolunteerNotification',
            'App\Listeners\FCM\SendMealWasReceivedByVolunteerFCM',
            'App\Listeners\Feed\CreateMealWasReceivedByVolunteerFeed',
        ],

        'App\Events\Delivery\NewMealWasDelivered' => [
            'App\Listeners\Delivery\SendMealWasDeliveredNotification',
            'App\Listeners\FCM\SendMealWasDeliveredFCM',
            'App\Listeners\Feed\CreateMealDeliveredFeed',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
