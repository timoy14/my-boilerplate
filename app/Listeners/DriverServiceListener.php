<?php

namespace App\Listeners;

use App\User;

class DriverServiceListener
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

        // if ($event->type == 'push_and_log_notif') {
        //     $notification = new Notification();
        //     $notification->user_id = $event->booking->user_id;
        //     if ($user->language == "ar") {
        //         $notification->title = $event->title_ar;
        //         $notification->message = $event->message_ar;
        //     } else {
        //         $notification->title = $event->title_en;
        //         $notification->message = $event->message;
        //     }

        //     $notification->save();
        // }

        $filter = array(array("field" => "tag", "key" => "userId", "value" => "userId_" . $event->user_id, "relation" => "="));
        $pushData = array();
        $title = array(
            'en' => $event->title, 'ar' => $event->title_ar);
        $content = array(
            'en' => $event->message, 'ar' => $event->message_ar);
        $hashes_array = array();
        $fields = array(
            'app_id' => '865c7b45-fa15-40bb-abd8-e0ec53189b03',
            'data' => null,
            'headings' => $title,
            'contents' => $content,
            'android_group' => $event->type, 'filters' => $filter);

        $fields = json_encode($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
            'Authorization: Basic ZjZkNDFlMDktN2Y4YS00OGRmLWExM2YtMGRiYThiZjg2ZWZl',
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