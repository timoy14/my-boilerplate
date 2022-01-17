<?php

namespace App\Services;

class OneSignalPushNotif
{
    protected $config;
    protected $apikey;

    public function __construct()
    {
        $this->apikey = env('ONESIGNAL_APIKEY');
    }

    public function push($fields) {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
            'Authorization: Basic '.$this->apikey
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        $test = json_decode($fields);
        // print_r($test->filters[0]->value);
        // die();
        
        \Log::debug(print_r(json_encode($response).'=====', true));
        \Log::debug(print_r($test->filters[0]->value, true));
        curl_close($ch);

        return $response;
    }

}





