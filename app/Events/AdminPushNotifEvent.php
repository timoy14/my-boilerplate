<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AdminPushNotifEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($AdminNotif)
    {
        $this->title_en = $AdminNotif["title_en"];
        $this->title_ar = $AdminNotif["title_ar"];
        $this->message_en = $AdminNotif["message_en"];
        $this->message_ar = $AdminNotif["message_ar"];
        $this->user_id_notify = $AdminNotif["user_id_notify"];
        $this->action = "";
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('admin-push-notif');
    }
}
