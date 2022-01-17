<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WhenUserBookedService
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $service;
    public $booking_payment_id;
    public $title;
    public $message;
    public $owner_id;
    public $customer_id;
    public $booking_id;
    public $type;
    public $id;
    public function __construct($booking, $payment, $service)
    {

        $this->service = $service;
        $this->booking_payment_id = $payment->id;
        $this->customer_id = $booking->user_id;
        $this->owner_id = $booking->owner_id;
        $this->booking_id = $booking->id;

        $this->type = "customer_new_booking_request";
        $this->id = $service->user_id;

        $this->title = "succesfully added";
        $this->message = "booking reservation succesfully added";

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('when-user-booked-service-event');
    }
}