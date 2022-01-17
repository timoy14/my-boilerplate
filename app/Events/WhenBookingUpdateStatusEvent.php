<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WhenBookingUpdateStatusEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    // public $service;
    // public $booking_payment_id;
    public $title;
    public $message;
    public $owner_id;
    public $customer_id;
    public $booking_id;
    public $type;
    public $id;
    public function __construct($booking)
    // $payment, $service
    {

        // $this->service = $service;
        // $this->booking_payment_id = $payment->id;
        $this->customer_id = $booking->user_id;
        $this->owner_id = $booking->owner_id;
        $this->booking_id = $booking->id;

        $this->type = "booking_status_update_request";
        $this->id = $booking->service_id;
        if ($this->booking->booking_status_id == 6) {
            $this->title = "end of service";
            $this->message = "end of service";
            // $this->title = "Pending";
            // $this->message = "Service set to pending Status ";
        }
        if ($this->booking->booking_status_id == 12) {
            $this->title = "start of service";
            $this->message = "start of service ";
            // $this->title = "Approve";
            // $this->message = "Admin Approve your service request ";
        }

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('when-booking-update-status-event');
    }
}