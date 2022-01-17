<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PharmacyServiceEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $purchase;
    public $title;
    public $message;
    public $title_ar;
    public $message_ar;
    public $user_id;
    public $type;
    public $id;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->purchase = $purchase;
        $this->user_id = $purchase->user_id;

        $this->type = "push_notif_only";
        $this->id = $purchase->id;
        if ($this->purchase->status == 'order_received') {
            $this->type = "push_and_log_notif";
            $this->message_ar = "  has been recieved by the pharamcy";
            $this->message = " has been recieved by the pharamcy";
        }

        if ($this->purchase->status == 'cancelled') {
            $this->type = "push_and_log_notif";
            $this->message_ar = "has been cancelled";

            $this->message = "has been cancelled";
        }

        if ($this->purchase->status == 'driver_accept') {

            $this->message_ar = "driver has been accepted you order";

            $this->message = "driver has been accepted you order";
        }
        if ($this->purchase->status == 'in_transit') {

            $this->message_ar = "driver is on the way";

            $this->message = "driver is on the way";
        }

        if ($this->purchase->status == 'order_prepared') {
            $this->type = "push_and_log_notif";
            $this->message_ar = "has been prepared by the pharmacy, you can now pay the order";
            $this->message = "has been prepared by the pharmacy, you can now pay the order";
        }
        if ($this->purchase->status == 'preparing_order') {

            $this->message_ar = "pharmacy has been preparing you order";
            $this->message = "pharmacy has been preparing you order";
        }

        if ($this->purchase->status == 'driver_arrived_at_store') {

            $this->message_ar = "driver has been arrived at the store";

            $this->message = "driver has been arrived at the store";
        }

        if ($this->purchase->status == 'customer_order_received') {

            $this->message_ar = "customer has been received the order ";

            $this->message = "customer has been received the order ";
        }

        if ($this->purchase->status == 'rated') {

            $this->message_ar = "pharmacy and driver has been rated";

            $this->message = "pharmacy and driver has been rated";
        }
        if ($this->purchase->status == 'order_complete') {
            $this->type = "push_and_log_notif";
            $this->message_ar = "has been complete";
            $this->message = "has been complete";
        }

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}