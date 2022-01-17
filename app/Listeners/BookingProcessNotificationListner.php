<?php

namespace App\Listeners;

class BookingProcessNotificationListner
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

        $notification = new Notification();
        $notification->user_id = $event->customer_id;
        $notification->title = $event->title;
        $notification->message = $event->message;
        $notification->save();

        $notification = new Notification();
        $notification->user_id = $event->owner_id;
        $notification->title = $event->title;
        $notification->message = $event->message;
        $notification->save();

        $tokens = Token::where('user_id', $event->customer_id)->get();
        foreach ($tokens as $token) {
            if (!empty($token->firebase_token)) {
                $headers = array
                    (
                    'Authorization: Bearer AAAArPHdyfg:APA91bFToQWsaWdADwzR7kMceozyT6xhV1o6whzdfMRMxIJgXEzeek8xpfAz-jFi720OuW_CjPNYM4-XyO6QELrcfLA-l4WP-esJ-x1uOV2Ixp6SRVkBQvQn0NWndKhld7puD3f13Sow',
                    'Content-Type: application/json',
                    'Accept: application/json',
                );
                $data = array("to" => $token->firebase_token,
                    "notification" => array("title" => $notification->title,
                        "body" => $notification->message,
                        "mutable_content" => true,
                        "sound" => "Tri-tone"),
                    "data" => array("url" => "https://app.alrapeh.com/images/defaults/alrapeh.png",
                        "type" => $event->type,
                        "service_id" => $event->id,
                        "booking_id" => $event->booking_id,

                    ));
                $data_string = json_encode($data);

                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                $result = curl_exec($ch);

                curl_close($ch);

            }
        }
    }
}