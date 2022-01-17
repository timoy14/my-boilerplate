<?php

namespace App\Http\Controllers;

use App\Helpers\HyperPayCopyAndPay;
use App\Model\Booking;
use App\Model\BookingPayment;
use App\Model\Service;
use App\User;
use Illuminate\Http\Request;

class HyperPayPaymentController extends Controller
{

    public function payInvoice(Request $request)
    {
        // $inv_id = $request->inv_id;

        $booking = Booking::find($request->booking_id);
        $service = Service::find($booking->service_id);
        $user = User::find($booking->user_id);
        $merchantTransactionId = uniqid();
        $arr = array(
            "merchantTransactionId" => $merchantTransactionId,
            "customerEmail" => $user->email,
            "customerName" => $user->name,

        );

        $data = array();
        $response = HyperPayCopyAndPay::request(str_replace(',', "", $request->amount), str_replace(',', "", $request->brand), $arr);
        $data['response'] = $response;
        $data['brand'] = str_replace(',', "", $request->brand);
        $data['discount_id'] = str_replace(',', "", $request->discount_id);
        $data['booking_id'] = str_replace(',', "", $request->booking_id);
        $data['user_id'] = str_replace(',', "", $user->id);
        $data['amount'] = str_replace(',', "", $request->amount);
        $data['commission_rate'] = str_replace(',', "", $request->commission_rate);
        $data['tax'] = str_replace(',', "", $request->tax);
        $data['type'] = str_replace(',', "", $request->type);
        $data['merchantTransactionId'] = $merchantTransactionId;
        $data['redirect_link'] = isset($request->redirect_link) ? $request->redirect_link : null;

        if ($request->brand == "APPLEPAY") {
            return view('admin.pay-invoice-apple')->with(compact('data'));
        }

        return view('admin.pay-invoice')->with(compact('data'));

    }

    public function returnUrl(Request $request)
    {

        $merchantTransactionId = $request->merchantTransactionId;
        // $redirect_link = urldecode($request->redirect_link);
        $card_brand = urldecode($request->brand);
        $url = "Alrapeh://payment?merchantTransactionId=" . $merchantTransactionId;
        $response = \App\Helpers\HyperPayCopyAndPay::paymentStatus($request->id, $request->brand);

        $result_code = $response['result']['code'];

        if ($result_code == "000.000.000" || $result_code == "000.100.110" || $result_code == "000.000.100") {
            $booking = Booking::find($request->booking_id);
            $service = Service::find($booking->service_id);
            $user = User::find($booking->user_id);

            $booking_payment = new BookingPayment();
            $booking_payment->booking_id = $booking->id;
            $booking_payment->amount = $request->amount;
            $booking_payment->payment_method = "ONLINE";
            $booking_payment->commission_rate = $request->commission_rate;
            $booking_payment->tax = $request->tax;
            $booking_payment->payment_id = $merchantTransactionId;

            $booking_payment->currency = ' SAR';
            $booking_payment->brand = $request->brand;
            $booking_payment->type = $request->type;
            if (isset($request->discount_id)) {
                $booking_payment->discount_id = $request->discount_id;
            }
            $booking_payment->save();
            if ($service->category_id != 4) {
                $booking->booking_status_id = 3;
            } else {
                if ($booking->booking_status_id == 1) {
                    $booking->booking_status_id = 2;
                } elseif ($booking->booking_status_id == 9) {
                    $booking->booking_status_id = 2;
                } else {
                    $booking->booking_status_id = 3;
                }
            }

            $booking->save();
            event(new WhenUserBookedService($booking, $booking_payment, $service));
            $arr_result = array(
                "status" => 1,
                "brand" => $card_brand,
                "redirect_link" => "Alrapeh://success?id=" . $response['id'],

                "message" => $response['result']['description'],
                "merchantTransactionId" => $merchantTransactionId,
                "data" => $booking_payment,
            );
        } else {

            $arr_result = array(
                "status" => 0,
                "brand" => $card_brand,
                "redirect_link" => "Alrapeh://error?id=" . $response['id'],
                "reference_id" => null,
                "message" => $response['result']['description'],
                "merchantTransactionId" => $merchantTransactionId,
            );
        }

        return view('admin.return-url')->with(compact('arr_result'));

    }
    public static function addbookingpayment($resourcePath, $brand)
    {
        $booking = Booking::find($args['booking_id']);
        $service = Service::find($booking->service_id);

        $booking_payment = new BookingPayment();
        $booking_payment->booking_id = $booking->id;
        $booking_payment->amount = $booking->amount;
        $booking_payment->payment_method = $args['method'];
        $booking_payment->commission_rate = $service->commission_rate;
        $booking_payment->tax = $service->tax;
        $booking_payment->payment_id = $args['payment_id'];

        $booking_payment->currency = $args['currency'];
        $booking_payment->brand = $args['brand'];
        $booking_payment->type = $args['type'];
        if (isset($args['discount_id'])) {
            $booking_payment->discount_id = $args['discount_id'];
        }
        $booking_payment->save();
        if ($service->category_id != 4) {
            $booking->booking_status_id = 3;
        } else {
            if ($booking->booking_status_id == 1) {
                $booking->booking_status_id = 2;
            } elseif ($booking->booking_status_id == 9) {
                $booking->booking_status_id = 2;
            } else {
                $booking->booking_status_id = 3;
            }
        }

        $booking->save();

    }

}
