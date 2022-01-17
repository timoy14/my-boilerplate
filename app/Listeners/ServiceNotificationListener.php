<?php

namespace App\Listeners;

use App\Model\Notification;

class ServiceNotificationListener
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
    public function handle($event)
    {
        $user = User::find($event->user_id);

        if ($event->type == 'push_and_log_notif') {
            $notification = new Notification();
            $notification->user_id = $event->booking->user_id;
            if ($user->language == "ar") {
                $notification->title = $event->title_ar;
                $notification->message = $event->message_ar;
            } else {
                $notification->title = $event->title_en;
                $notification->message = $event->message;
            }

            $notification->save();
        }

        $filter = array(array("field" => "tag", "key" => "userId", "value" => "userId_" . $event->user_id, "relation" => "="));
        $pushData = array();
        $title = array(
            'en' => 'bravo notification', 'ar' => 'bravo notification ar');
        $content = array(
            'en' => $event->message, 'ar' => $event->message_ar);
        $hashes_array = array();
        $fields = array(
            'app_id' => '7382ebdf-a0b7-467b-bc55-29247856d289',
            'data' => null,
            'headings' => $title,
            'contents' => $content,
            'android_group' => $event->type, 'filters' => $filter);

        $fields = json_encode($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
            'Authorization: Basic MmI4N2ZmZDUtNGM1OS00Y2M1LTg0OTMtMTQxNTkxNzNjMWU4',
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        curl_close($ch);

    }
}