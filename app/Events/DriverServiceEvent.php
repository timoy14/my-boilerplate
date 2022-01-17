<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DriverServiceEvent
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
    public function __construct($purchase, $action)
    {
        $this->purchase = $purchase;
        $this->user_id = $purchase->driver_id;
        // referrence_id
        $this->type = "push_notif_only";
        $this->id = $purchase->id;
        if ($action == 'payment') {
            $this->type = "push_and_log_notif";
            $this->title = 'order payment';
            $this->title_ar = 'order payment';
            $this->message_ar = " order " . $purchase->referrence_id . "has been paid by the customer " . $purchase->user->name . ".";
            $this->message = " order " . $purchase->referrence_id . "has been paid by the customer " . $purchase->user->name . ".";
        } elseif ($this->purchase->status == 'cancelled') {
            $this->type = "push_and_log_notif";

            $this->title = 'cancelled';
            $this->title_ar = 'cancelled';
            $this->message_ar = "order " . $purchase->referrence_id . "has been cancelled";
            $this->message = "order " . $purchase->referrence_id . "has been cancelled";
        } elseif ($this->purchase->status == 'driver_accept') {

            $this->title = 'driver accept order';
            $this->title_ar = 'driver accept order';
            $this->message_ar = "congratulation you acceprt order " . $purchase->referrence_id . ".";
            $this->message = "congratulation you acceprt order " . $purchase->referrence_id . ".";
        } elseif ($this->purchase->status == 'in_transit') {

            $this->title = 'driver in transit';
            $this->title_ar = 'driver in transit';
            $this->message_ar = "you recevied the order " . $purchase->referrence_id . " and on the way to the destinatio.n";
            $this->message = "you recevied the order " . $purchase->referrence_id . " and on the way to the destination.";
        } elseif ($this->purchase->status == 'order_complete') {
            $this->title = 'order complete';
            $this->title_ar = 'order complete';

            $this->message_ar = "customer  " . $purchase->user->name . " " . $purchase->user_id . "has been completed the order " . $purchase->referrence_id;
            $this->message = "customer " . $purchase->user->name . " " . $purchase->user_id . "has been completed the order" . $purchase->referrence_id;
        }
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('driver-service-event');
    }
}