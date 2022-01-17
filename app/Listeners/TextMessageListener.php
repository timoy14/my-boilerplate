<?php

namespace App\Listeners;

use App\Events\TextMessageEvent;
use App\User;

class TextMessageListener
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
     * @param  object  $event
     * @return void
     */
    public function handle(TextMessageEvent $event)
    {
        switch ($event->action) {
            case 'REGISTER':
                if ($event->user_id == 1) {
                    $numbers = $event->phone;
                } else {
                    $user = User::findOrFail($event->user_id);
                    $numbers = $user->phone;
                }

                $message = "  كود التفعيل الخاص بكم:" . $event->code . $event->otp_hash;

                return $this->sendTextMessage($numbers, $message);
                break;
            case 'RESEND_OTP':
                if ($event->user_id == 1) {
                    $numbers = $event->phone;
                } else {
                    $user = User::findOrFail($event->user_id);
                    $numbers = $user->phone;
                }
                $message = "  كود التفعيل الخاص بكم:" . $event->code . $event->otp_hash;

                return $this->sendTextMessage($numbers, $message);
                break;
            case 'FORGOT':
                if ($event->user_id == 1) {
                    $numbers = $event->phone;
                } else {
                    $user = User::findOrFail($event->user_id);
                    $numbers = $user->phone;
                }
                $message = "  كود التفعيل الخاص بكم:" . $event->code . $event->otp_hash;
                return $this->sendTextMessage($numbers, $message);
                break;

            default:
                return 'FAILED';
                break;
        }
    }
    public function sendTextMessage($numbers, $message)
    {

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://www.msegat.com/gw/sendsms.php');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);

        curl_setopt($ch, CURLOPT_POST, true);
        // $fields = <<<EOT
        // {
        //   "userName": "Nabilmanager",
        //   "numbers": $numbers,
        //   "userSender": "BravoCare",
        //   "apiKey": "e45d6db8d5d7b4da0ea7f2c9b36fab2f",
        //   "msg": $message
        // }
        // EOT;

        $data = array(
            "userName" => "Nabilmanager",

            "numbers" => $numbers,
            "userSender" => "BravoCare",
            "apiKey" => "e45d6db8d5d7b4da0ea7f2c9b36fab2f",
            "msg" => $message,

        );
        $data_string = json_encode($data);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json",
        ));

        $response = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);

        // var_dump($info["http_code"]);
        return $response;
    }
}