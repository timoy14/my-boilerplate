<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WhenAdminCancelBookingEvent
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
    public function __construct($booking, $payments, $service)
    {

        $this->service = $service;
        $this->booking_payment_id = $payments;
        $this->customer_id = $booking->user_id;
        $this->owner_id = $booking->owner_id;
        $this->booking_id = $booking->id;

        $this->type = "admin_answer_cancel_request";
        $this->id = $service->user_id;

        if ($this->booking->booking_status_id == 11) {
            $this->title = " reject refund request";
            $this->message = "admin reject a refund request, please contact admin";
            // $this->title = "Pending";
            // $this->message = "Service set to pending Status ";
        }
        if ($this->booking->booking_status_id == 10) {
            $this->title = "refunded successfully";
            $this->message = "admin refunded a booking";
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
        return new PrivateChannel('when-admin-cancel-booking-event');
    }
}