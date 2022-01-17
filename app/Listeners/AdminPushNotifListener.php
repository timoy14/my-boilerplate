<?php

namespace App\Listeners;

use App\Events\AdminPushNotifEvent;
use App\Services\OneSignalPushNotif;
use App\Model\LogNotification;
use App\User;

class AdminPushNotifListener
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
     * @param  UpdateStatusEvent  $event
     * @return void
     */
    public function handle(AdminPushNotifEvent $event)
    {
        
        $title_en = $event->title_en;
        $title_ar = $event->title_ar;
        $message_en = $event->message_en;
        $message_ar = $event->message_ar;
        $user_id_notify = $event->user_id_notify;
        
        $filter = array(
                        array(  
                                "field" => "tag",
                                "key" => "userId",
                                "value" => "userId_" . $user_id_notify,
                                "relation" => "="
                            )
                        );
        
        $title = array(
            'en' => $title_en, 'ar' => $title_ar);
        $content = array(
            'en' => $message_en, 'ar' => $message_ar);
        $hashes_array = array();

        $fields = array(
            'app_id' => env('ONESIGNAL_APPID'),
            'data' => null,
            'headings' => $title,
            'contents' => $content,
            'android_group' => $event->action, 
            'filters' => $filter
        );

        $fields = json_encode($fields);

        // echo "<pre>";
        // $test = json_decode($fields);
        // print_r($test->filters);
        // echo "</pre>";
        // die();

        $OneSignalPushNotif = new OneSignalPushNotif;
        $OneSignalPushNotif->push($fields);
    }
}
