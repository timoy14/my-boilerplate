<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($code, $email, $action, $otp_hash)
    {
        $this->email = $email;
        $this->code = $code;

        $this->action = $action;
        $this->otp_hash = $otp_hash;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.otp')->subject('seirin otp verification')->with([
            'email' => $this->email,
            'code' => $this->code,
            'action' => $this->action,
            'otp_hash' => $this->otp_hash,

        ]);
    }
}