<?php

namespace App\Helpers;

class HyperPayCopyAndPay
{
    public static function request($price, $brand, $arr)
    {
        $entityId = "8ac7a4c87641b3ad017642cb32a704d0";
        $mada = "8ac7a4c87641b3ad017642cc196604d8";
        $apple = "8ac7a4c876a1697f0176b33dc0b81cdd";
        if ($brand == 'MADA') {
            $entityId = $mada;
        } elseif ($brand == 'APPLEPAY') {
            $entityId = $apple;
        }

        $url = "https://test.oppwa.com/v1/checkouts";
        // $url = "https://test.oppwa.com/";

        $data = "entityId=" . $entityId .
            "&currency=SAR" .
            "&amount=" . $price .
            "&paymentType=DB" .
            "&merchantTransactionId=" . $arr['merchantTransactionId'] .
            "&customer.email=" . $arr['customerEmail'] .
            "&billing.country=SA" .
            "&billing.city=Riyadh" .
            "&billing.state=Riyadh" .
            "&billing.postcode=13246" .
            "&billing.street1=Shaikh Hasan Ibn Hussain Ibn Ali Rd" .
            "&customer.givenName=" . $arr['customerName'] .
            "&customer.surname=" . $arr['customerName']

        ;

        // var_dump($data);
        // exit;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer OGFjN2E0Yzg3NjQxYjNhZDAxNzY0MmNhYzk5YjA0Y2N8RFE4U3A1ZFlkRw=='));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        // var_dump($responseData);
        // exit;
        return json_decode($responseData, true);
    }

    public static function paymentStatus($resourcePath, $brand)
    {
        $entityId = "8ac7a4c87641b3ad017642cb32a704d0";
        $mada = "8ac7a4c87641b3ad017642cc196604d8";
        $apple = "8ac7a4c876a1697f0176b33dc0b81cdd";
        if ($brand == 'MADA') {
            $entityId = $mada;
        } elseif ($brand == 'APPLEPAY') {
            $entityId = $apple;
        }
        $url = "https://test.oppwa.com//v1/checkouts/" . $resourcePath . "/payment";
        $url .= "?entityId=" . $entityId;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer OGFjN2E0Yzg3NjQxYjNhZDAxNzY0MmNhYzk5YjA0Y2N8RFE4U3A1ZFlkRw=='));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        return json_decode($responseData, true);
    }

}