<?php

namespace App\Listeners;

use App\Events\WhenAdminReplyFeedback;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendMessageViaEmail
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
     * @param  WhenAdminReplyFeedback  $event
     * @return void
     */
    public function handle(WhenAdminReplyFeedback $event)
    {
        // echo $event->email;
        // echo $event->message;
    }
}
