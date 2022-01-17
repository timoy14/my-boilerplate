<?php

namespace App\Listeners;

use App\Events\WhenUserLoggedIn;
use App\Model\Notification;

class LoggedInNotification
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
     * @param  WhenUserLoggedIn  $event
     * @return void
     */
    public function handle(WhenUserLoggedIn $event)
    {
        $notification = new Notification();
        $notification->user_id = $event->user->id;
        $notification->title = 'اهلا بك ';
        $notification->message = 'تم التسجيل بنجاح ';
        // $notification->title = 'Welcome';
        // $notification->message = 'You have successfully registered!';
        $notification->save();
        // Mail::to('admin@alrapeh.com')->send(new NewBookingMail(134));
    }
}