<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CustomerServiceEvent
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
        $this->user_id = $purchase->user_id;
        // $purchase->referrence_id
        $this->type = "push_notif_only";
        $this->id = $purchase->id;

        if ($action == 'payment') {
            $this->type = "push_and_log_notif";
            $this->title = 'order payment';
            $this->title_ar = 'order payment';
            $this->message_ar = "thank you for paying order " . $purchase->referrence_id . ".";
            $this->message = "thank you for paying  order " . $purchase->referrence_id . ".";
        } elseif ($this->purchase->status == 'order_received') {
            $this->type = "push_and_log_notif";
            $this->title = 'order received';
            $this->title_ar = 'order received';
            $this->message_ar = "order " . $purchase->referrence_id . " has been recieved by the pharamcy";
            $this->message = "order " . $purchase->referrence_id . " has been recieved by the pharamcy";
        } elseif ($this->purchase->status == 'cancelled') {
            $this->type = "push_and_log_notif";

            $this->title = 'cancelled';
            $this->title_ar = 'cancelled';

            $this->message_ar = "الطلب " . $purchase->referrence_id . "تم الغاءه";
            $this->message = "order " . $purchase->referrence_id . "has been cancelled";
        } elseif ($this->purchase->status == 'driver_accept') {

            $this->title = 'driver accept order';
            $this->title_ar = 'driver accept order';

            $this->message_ar = "order " . $purchase->referrence_id . " has been accepted by driver " . $purchase->driver->name . " " . $purchase->driver_id . ".";
            $this->message = "order " . $purchase->referrence_id . " has been accepted by driver " . $purchase->driver->name . " " . $purchase->driver_id . ".";
        } elseif ($this->purchase->status == 'in_transit') {

            $this->title = 'driver in transit';
            $this->title_ar = 'driver in transit';

            $this->message_ar = $purchase->referrence_id . "s driver is on the way to the destination";
            $this->message = $purchase->referrence_id . "s driver is on the way to the destination";
        } elseif ($this->purchase->status == 'order_prepared') {
            $this->type = "push_and_log_notif";
            $this->title = 'order prepared';
            $this->title_ar = 'order prepared';

            $this->message_ar = "order " . $purchase->referrence_id . " has been prepared by the pharmacy, " . $purchase->pharmacy->pharmacy_name . " you can now pay the order.";
            $this->message = "order " . $purchase->referrence_id . " has been prepared by the pharmacy, " . $purchase->pharmacy->pharmacy_name . " you can now pay the order.";
        } elseif ($this->purchase->status == 'preparing_order') {
            $this->title = 'your order is placed !  ';
            $this->title_ar = 'تم الدفع بنجاح';

            $this->message_ar = " الطلب " . $purchase->referrence_id . "تم حجزه بنجاح  " . $purchase->user->name . ".";
            $this->message = " order " . $purchase->referrence_id . "has been placed " . $purchase->user->name . ".";
        } elseif ($this->purchase->status == 'driver_arrived_at_store') {
            $this->title = 'driver arrived at store';
            $this->title_ar = 'driver arrived at store ';

            $this->message_ar = "driver " . $purchase->driver->name . " " . $purchase->driver_id . "has been arrived at the store";
            $this->message = "driver " . $purchase->driver->name . " " . $purchase->driver_id . " has been arrived at the store";
        } elseif ($this->purchase->status == 'driver_arrived') {
            $this->title = 'driver arrived at store';
            $this->title_ar = 'driver arrived at store ';

            $this->message_ar = "driver " . $purchase->driver->name . " " . $purchase->driver_id . "has been arrived at the destination please claim your order.";
            $this->message = "driver " . $purchase->driver->name . " " . $purchase->driver_id . "has been arrived at the destination please claim your order.";
        }

        // if ($this->purchase->status == 'customer_order_received') {
        //     $this->title = 'customer order received ';
        //     $this->title_ar = 'customer order received ';

        //     $this->message_ar = "customer has been received the order ";
        //     $this->message = "customer has been received the order ";
        // }

        // if ($this->purchase->status == 'rated') {
        //     $this->title = 'order received';
        //     $this->title_ar = 'order received';

        //     $this->message_ar = "pharmacy and driver has been rated";
        //     $this->message = "pharmacy and driver has been rated";
        // }
        // if ($this->purchase->status == 'order_complete') {
        //     $this->type = "push_and_log_notif";
        //     $this->title = 'order received';
        //     $this->title_ar = 'order received';

        //     $this->message_ar = "has been complete";
        //     $this->message = "has been complete";
        // }

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('customer-service-event');
    }
}