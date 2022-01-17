<?php

namespace App\Http\Controllers\Payments;

use App\Events\CustomerServiceEvent;
use App\Events\DriverServiceEvent;
use App\Http\Controllers\Controller;
use App\Model\Purchase;
use App\Services\FirebaseRealtimeDatabase;
use App\User;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

    public function store($purchased_id)
    {
        if (!$purchased_id) {
            return [
                "error" => [
                    "message" => "purchased_id does not exist",
                ],
            ];
        }
        $purchase = Purchase::find($purchased_id);

        // if ($purchase->status != "order_prepared") {
        //     return [
        //         "error" => [
        //             "message" => "you are not allowed to process this action",
        //         ],
        //     ];
        // }
        $user = User::find($purchase->user_id);

        $user_id = $user->id;
        $name = isset($user->name) ? $user->name : $user->phone;
        $email = $user->email;
        $phone = $user->phone;

        $transaction = rand(1, 10000000000);
        $data = array(
            'amount' => $purchase->total_amount,
            'currency' => 'SAR',
            "threeDSecure" => true,
            "save_card" => false,
            'description' => 'App Subscription',
            'metadata' => array('user_id' => $user_id, 'purchase_id' => $purchase->id),
            "receipt" => array(
                "email" => false,
                "sms" => true,
            ),
            'customer' => array(
                'first_name' => $name,
                "middle_name" => $name,
                "last_name" => $name,
                'email' => $email,
                'phone' => array('country_code' => "966",
                    'number' => $phone,
                ),
            ),
            'reference' => array('transaction' => $transaction . "_" . $user_id),
            'source' => array('id' => 'src_all'),
            'redirect' => array('url' => route('payment.redirect')),
        );

        $curl = curl_init();
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.tap.company/v2/charges",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                "authorization: Bearer " . getenv('TAP_SK_TOKEN'),
                "content-type: application/json",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        $responseArr = json_decode($response, 1);

        return redirect()->away($responseArr['transaction']['url']);
    }

    public function redirectUrl(Request $request)
    {
        $tap_chg_id = $request->tap_id;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.tap.company/v2/charges/" . $tap_chg_id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "{}",
            CURLOPT_HTTPHEADER => array(
                "authorization: Bearer " . getenv('TAP_SK_TOKEN'),
                "content-type: application/json",
            ),
        ));

        $response = curl_exec($curl);
        $responseArr = json_decode($response, 1);

        $purchase = Purchase::find($responseArr["metadata"]["purchase_id"]);
        $purchase->tap_id = $responseArr["id"];
        $purchase->tap_code_status = $responseArr["response"]["code"];
        $purchase->payment_timestamp = $responseArr["transaction"]["created"];
        $purchase->payment_status = $responseArr["response"]["message"];
        $purchase->payment_type = $responseArr["source"]["payment_type"];
        $purchase->invoice_token = $responseArr["reference"]["transaction"];

        if ($responseArr["response"]["code"] == 000) {
            // $purchase->status = "payment";
            $success = true;
        }

        $purchase->save();

        if ($responseArr["response"]["code"] == 000) {

            event(new CustomerServiceEvent($purchase, 'payment'));
            event(new DriverServiceEvent($purchase, 'payment'));
            $FirebaseRealtimeDatabase = new FirebaseRealtimeDatabase;
            $FirebaseRealtimeDatabase->insert_data($purchase->id, "orders");
        }

        $url = "bravocare://payment?id=" . $purchase->id;
        return redirect()->away($url);
    }

    public function getChargeDetails($purchase_id)
    {
        $purchase = Purchase::find($purchase_id);

        return [

            "tap_code_status" => isset($purchase->tap_code_status) ? $purchase->tap_code_status : null,
            "payment_timestamp" => isset($purchase->payment_timestamp) ? $purchase->payment_timestamp : null,
            "payment_status" => isset($purchase->payment_status) ? $purchase->payment_status : null,
            "payment_type" => isset($purchase->payment_type) ? $purchase->payment_type : null,

        ];
    }
}