<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WhenAdminReplyBankPaymentEvent
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

        $this->type = "admin_answer_bank_request";
        $this->id = $service->user_id;

        if ($this->payment->status == 0) {
            $this->title = "قيد الانتظار ";
            $this->message = "admin reject a bank request, the banking details does not match on the booking";
            // $this->title = "Pending";
            // $this->message = "Service set to pending Status ";
        }
        if ($this->payment->status == 1) {
            $this->title = "م الموافقة";
            $this->message = "admin approve a bank request";
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
        return new PrivateChannel('when-admin-reply-bank-payment');
    }
}