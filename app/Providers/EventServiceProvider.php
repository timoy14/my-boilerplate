<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        // Api
        \App\Events\WhenUserLoggedIn::class => [
            \App\Listeners\LoggedInNotification::class,
        ],

        \App\Events\TextMessageEvent::class => [
            \App\Listeners\TextMessageListener::class,
        ],

        // Dashboard
        \App\Events\WhenAdminReplyFeedback::class => [
            \App\Listeners\SendMessageViaEmail::class,
        ],
        \App\Events\ServiceStatusUpdatedEvent::class => [
            \App\Listeners\ServiceNotificationListener::class,
        ],
        \App\Events\WhenAdminReplyBankPaymentEvent::class => [
            \App\Listeners\RequestNotificationListner::class,
        ],
        \App\Events\WhenUserBookedService::class => [
            \App\Listeners\BookingNotificationListner::class,
        ],

        \App\Events\WhenAdminCancelBookingEvent::class => [
            \App\Listeners\RequestNotificationListner::class,
        ],
        \App\Events\WhenBookingUpdateStatusEvent::class => [
            \App\Listeners\BookingProcessNotificationListner::class,
        ],
        \App\Events\AdminPushNotifEvent::class => [
            \App\Listeners\AdminPushNotifListener::class,
        ],
        \App\Events\CustomerServiceEvent::class => [
            \App\Listeners\CustomerServiceListener::class,
        ],
        \App\Events\DriverServiceEvent::class => [
            \App\Listeners\DriverServiceListener::class,
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