<?php

namespace App\Http\Controllers\Dashboard\Admin\Messages;

use App\Http\Controllers\Controller;
use App\Model\Purchase;
use Auth;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(Request $request)
    {

        $orders = Purchase::where('pharmacy_id', $request->pharmacy_id)->get()->map(function ($order) {
            return [
                'id' => $order->id,
                'name' => $order->user->name,
                'avatar' => $order->user->avatar,
            ];
        });

        return view('admin.messages.messages', compact('orders'));
    }

    public function conversation(Purchase $order, Request $request)
    {

        $purchase = $order;
        $data = [];

            if ($request->message == 'driver') {
                $owner_id = $order->driver_id;
                $owner_name = $order->driver->name;
                $owner_photo = $order->driver->avatar;

            } else {
                $owner_id = $order->pharmacy->id;
                $owner_name = $order->pharmacy->pharmacy_name;
                $owner_photo =$order->pharmacy->pharmacy_name;
            }

            $customer_id = $order->user_id;
            $customer_name = $order->user->name;
            $customer_photo = $order->user->avatar;

            $data = [
                "type" => $request->message,
                "conversation_id" => $order->id,
                "customer_id" => $customer_id,
                "customer_name" => $customer_name,
                "customer_photo" => $customer_photo,
                "owner_id" => $owner_id,
                "owner_name" => $owner_name,
                "owner_photo" => $owner_photo,
                "purchase" => $order,
            ];

        return view('admin.messages.conversation', $data);
    }

    public function send(Order $order)
    {
        // $order->notify(new MessageNotification($request->message));
        return ['success' => true];
    }
}