<?php

namespace App\GraphQL\Mutations;

use App\Events\CustomerServiceEvent;
use App\Events\DriverServiceEvent;
use App\Model\Cart;
use App\Model\Discount;
use App\Model\Purchase;
use App\Model\PurchasePharmacyProduct;
use App\Model\Setting;
use App\Model\UserAddress;
use App\Services\CloudinaryFileUpload;
use App\User;
use Carbon\Carbon;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class BookingMutator
{
    /**
     * Return a value for the field.
     *
     * @param  null  $rootValue Usually contains the result returned from the parent field. In this case, it is always `null`.
     * @param  mixed[]  $args The arguments that were passed into the field.
     * @param  \Nuwave\Lighthouse\Support\Contracts\GraphQLContext  $context Arbitrary data that is shared between all fields of a single query.
     * @param  \GraphQL\Type\Definition\ResolveInfo  $resolveInfo Information about the query itself, such as the execution state, the field name, path to the field from the root, and more.
     * @return mixed
     */

    public function findDiscountCode($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        return Discount::where('code', $args['code'])->first();
    }

    public function addPurchase($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {

        // TODO implement the resolver

        if (isset($args['user_address_id'])) {
            $user_address_exist = UserAddress::where('id', $args['user_address_id'])->where('user_id', Auth()->user()->id)->exists();
            if (!$user_address_exist) {
                return [
                    'status' => false,
                    'message' => "there is a problem on user address",
                ];
            }
        }
        $setting = Setting::first();
        $time_stamp = Carbon::now();
        $todayDate = Carbon::today()->toDateString();
        $sub_total = 0;
        $discount_amount = 0;
        $cart = Cart::find($args["cart_id"]);
        $discount_exist = false;

        $pharmacy_exist = User::where('id', $cart->pharmacy_id)->where('role_id', 3)->exists();
        if (!$pharmacy_exist) {
            return [
                'status' => false,
                'message' => "this pharmacy is not available",
            ];
        }

        foreach ($cart->cart_pharmacy_products as $cart_pharmacy_product) {
            if ($todayDate >= $cart_pharmacy_product->pharmacy_product_variation->promo_date_start && $todayDate <= $cart_pharmacy_product->pharmacy_product_variation->promo_date_end) {
                $sub_total = ($sub_total + $cart_pharmacy_product->pharmacy_product_variation->promo_price) * $cart_pharmacy_product->quantity;
            } else {
                $sub_total = ($sub_total + $cart_pharmacy_product->pharmacy_product_variation->price) * $cart_pharmacy_product->quantity;
            }
        }

        if (isset($args['discount'])) {
            $discount_exist = Discount::where('code', $args['code'])->exists();

            if ($discount_exist) {
                $discount = Discount::where('code', $args['code'])->first();

                if ($discount->rate != null) {
                    $discount_amount = $sub_total * ($discount->rate / 100);
                } elseif ($discount->off != null) {
                    $discount_amount = $discount->off;
                }
            }
        }

        if ($args["distance"] < 5) {
            $delivery_fee = $setting->delivery_fee_less_than_5_km;
        } elseif ($args["distance"] >= 5 && $args["distance"] <= 10) {
            $delivery_fee = $setting->delivery_fee_5_to_10_km;
        } elseif ($args["distance"] > 10) {
            $delivery_fee = $setting->delivery_fee_more_than_10_km;
        }

        $total_amount = $sub_total + $delivery_fee - $discount_amount;
        $tax_rate = $setting->tax_rate;

        $driver_commission = $delivery_fee * ($setting->driver_commission / 100);
        $driver_commission = $delivery_fee - $driver_commission;
        $admin_commission = $total_amount * ($setting->admin_commission / 100);

        $tax_amount = $total_amount * ($tax_rate / 100);

        $booking = new Purchase();
        $booking->referrence_id = uniqid();
        $booking->user_id = Auth()->user()->id;
        $booking->pharmacy_id = $cart->pharmacy_id;
        // $booking->user_address_id = $args['user_address_id'];
        $booking->address_text = isset($args['address_text']) ? $args['address_text'] : null;
        $booking->latitude = isset($args['latitude']) ? $args['latitude'] : null;
        $booking->longitude = isset($args['longitude']) ? $args['longitude'] : null;
        $booking->distance = isset($args["distance"]) ? $args["distance"] : null;
        $booking->discount_id = $discount_exist ? $discount->id : null;
        $booking->driver_commission = $driver_commission;
        $booking->admin_commission = $admin_commission;
        $booking->delivery_fee = $delivery_fee;

        $booking->tax_rate = $setting->tax_rate;

        $booking->sub_total = $sub_total;

        $booking->status = "order_received";
        $booking->status_notes = "(" . $time_stamp . ") order has been created. %%";
        $booking->discount = $discount_amount;
        $booking->tax_amount = $tax_amount;
        $booking->total_amount = $total_amount + $tax_amount;
        $booking->save();

        event(new CustomerServiceEvent($booking, 'addPurchase'));
        event(new DriverServiceEvent($booking, 'addPurchase'));
        foreach ($cart->cart_pharmacy_products as $cart_pharmacy_product) {

            $current_cart_pharmacy_product = $cart_pharmacy_product->pharmacy_product;
            $current_cart_product_variation = $cart_pharmacy_product->pharmacy_product_variation;

            if ($todayDate >= $current_cart_product_variation->promo_date_start && $todayDate <= $current_cart_product_variation->promo_date_end) {

                $price = $current_cart_product_variation->price;
                $promo_price = $current_cart_product_variation->promo_price;
                $total_amount = $price * $cart_pharmacy_product->promo_price;
            } else {
                $price = $current_cart_product_variation->price;
                $promo_price = 0;

                $total_amount = $price * $cart_pharmacy_product->quantity;
            }

            $purchase_pharmacy_product = new PurchasePharmacyProduct();
            $purchase_pharmacy_product->purchase_id = $booking->id;
            $purchase_pharmacy_product->pharmacy_id = $cart->pharmacy_id;
            $purchase_pharmacy_product->product_category_id = $current_cart_pharmacy_product->product_category_id;
            $purchase_pharmacy_product->pharmacy_product_id = $current_cart_pharmacy_product->id;
            $purchase_pharmacy_product->pharmacy_product_variation_id = $current_cart_product_variation->id;
            $purchase_pharmacy_product->en = $current_cart_product_variation->en;
            $purchase_pharmacy_product->ar = $current_cart_product_variation->ar;
            $purchase_pharmacy_product->quantity = $cart_pharmacy_product->quantity;
            $purchase_pharmacy_product->price = $price;
            $purchase_pharmacy_product->total_amount = $total_amount;
            $purchase_pharmacy_product->promo_price = $promo_price;
            $purchase_pharmacy_product->description = $current_cart_pharmacy_product->description;
            $purchase_pharmacy_product->save();
        }
        $cart->delete();

        return [
            'status' => true,

            'id' => $booking->id,
            'referenceId' => $booking->referrence_id,
            'message' => "purchase succesfully added: " . $booking->referrence_id,
        ];

    }

    public function cancelBooking($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $time_stamp = Carbon::now();
        $purchased = Purchase::find($args['purchased_id']);

        if ($purchased->user_id != Auth()->user()->id) {
            return [
                'status' => false,
                'message' => "booking reservation is not on your account",
            ];
        }

        if ($purchased->payment_timestamp != null) {
            return [
                'status' => false,
                'message' => "Pharmacy confirmed the order already.",
            ];
        }

        $purchased->status = "cancelled";

        $purchased->status_notes = $purchased->status_notes . "(" . $time_stamp . ")  Purchase  succesfully cancel" . $purchased->referrence_id . "%%";

        $purchased->save();
        event(new CustomerServiceEvent($purchased, 'cancelBooking'));
        event(new DriverServiceEvent($purchased, 'cancelBooking'));
        return [
            'id' => $purchased->id,
            'status' => true,
            'message' => "Purchase  succesfully cancel" . $purchased->referrence_id,
        ];
    }

    public function driverAcceptDelivery($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $time_stamp = Carbon::now();
        $purchase = Purchase::find($args['purchase_id']);

        if ($purchase->status == "order_prepared") {
            $purchase->status = "driver_accept";
            $purchase->driver_id = Auth()->user()->id;
            $purchase->status_notes = $purchase->status_notes . "(" . $time_stamp . ")  driver accept the delivery %%";

            $purchase->save();
            event(new CustomerServiceEvent($purchase, 'driverAcceptDelivery'));
            event(new DriverServiceEvent($purchase, 'driverAcceptDelivery'));
            return [
                'status' => true,
                'message' => "driver_accept_the_delivery",
                'id' => $purchase->id,
                'referenceId' => $purchase->referrence_id,
            ];
        } else {
            return [
                'status' => false,
                'message' => "this status cant be change by user",
            ];

        }

    }
    public function driverArrivedAtStore($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $time_stamp = Carbon::now();
        $purchase = Purchase::find($args['purchase_id']);

        if ($purchase->status == "driver_accept" && $purchase->driver_id == Auth()->user()->id) {
            $purchase->status = "driver_arrived_at_store";
            $purchase->status_notes = $purchase->status_notes . " (" . $time_stamp . ")  driver arrived at store %%";

            $purchase->save();
            event(new CustomerServiceEvent($purchase, 'driverArrivedAtStore'));
            event(new DriverServiceEvent($purchase, 'driverArrivedAtStore'));
            return [
                'status' => true,
                'message' => "driver_arrived_at_store",
                'id' => $purchase->id,
                'referenceId' => $purchase->referrence_id,
            ];
        } else {
            return [
                'status' => false,
                'message' => "this status cant be change by user",
            ];

        }

    }
    public function driverInTransit($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $time_stamp = Carbon::now();
        $purchase = Purchase::find($args['purchase_id']);

        if ($purchase->status == "driver_arrived_at_store" && $purchase->driver_id == Auth()->user()->id) {
            $purchase->status = "in_transit";
            $purchase->status_notes = $purchase->status_notes . " (" . $time_stamp . ")  driver in transit %%";

            $purchase->save();
            event(new CustomerServiceEvent($purchase, 'driverInTransit'));
            event(new DriverServiceEvent($purchase, 'driverInTransit'));
            return [
                'status' => true,
                'message' => "driver_in_transit",
                'id' => $purchase->id,
                'referenceId' => $purchase->referrence_id,
            ];
        } else {
            return [
                'status' => false,
                'message' => "this status cant be change by user",
            ];

        }

    }

    public function driverArrived($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $time_stamp = Carbon::now();
        $purchase = Purchase::find($args['purchase_id']);

        if (($purchase->status == "in_transit" || $purchase->status == "driver_arrived_at_store") && $purchase->driver_id == Auth()->user()->id) {
            $purchase->status = "driver_arrived";
            $purchase->status_notes = $purchase->status_notes . " (" . $time_stamp . ")  driver arrived at the destination %%";

            $purchase->save();
            event(new CustomerServiceEvent($purchase, 'driverArrived'));
            event(new DriverServiceEvent($purchase, 'driverArrived'));
            return [
                'status' => true,
                'message' => "driver arrived",
                'id' => $purchase->id,
                'referenceId' => $purchase->referrence_id,
            ];
        } else {
            return [
                'status' => false,
                'message' => "this status cant be change by user",
                'id' => $purchase->id,
                'referenceId' => $purchase->referrence_id,
            ];

        }

    }

    public function orderComplete($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $time_stamp = Carbon::now();

        $purchase = Purchase::find($args['purchase_id']);
        if ($purchase->payment_status != 'Captured') {

            return [
                'status' => true,
                'message' => "action can't be done, customer need to pay first",
                'id' => $purchase->id,
                'referenceId' => $purchase->referrence_id,
            ];
        }
        if ($purchase->status == "driver_arrived" && $purchase->driver_id == Auth()->user()->id) {
            $purchase->status = "order_complete";

            event(new CustomerServiceEvent($purchase, 'orderComplete'));
            event(new DriverServiceEvent($purchase, 'orderComplete'));

            $purchase->status_notes = $purchase->status_notes . " (" . $time_stamp . ")  order complete %%";

            if (isset($args['proof_of_transaction'])) {
                $file = $args['proof_of_transaction'];
                $cloudinaryFileUpload = new CloudinaryFileUpload();
                $purchase->proof_of_transaction = $cloudinaryFileUpload->file_upload($file, 'proof_of_transaction');
            }

            $purchase->save();

            return [
                'status' => true,
                'message' => "order_complete",
                'id' => $purchase->id,
                'referenceId' => $purchase->referrence_id,
            ];
        } else {
            return [
                'status' => false,
                'message' => "this status cant be change by user",
                'id' => $purchase->id,
                'referenceId' => $purchase->referrence_id,
            ];

        }

    }

    public function customerOrderReceived($rootValue, array $args, GraphQLContext $context, ResolveInfo $resolveInfo)
    {
        $purchase = Purchase::find($args['purchase_id']);

        if ($purchase->payment_status != 'Captured') {

            return [
                'status' => true,
                'message' => "action can't be done, customer need to pay first",
                'id' => $purchase->id,
                'referenceId' => $purchase->referrence_id,
            ];
        }

        $time_stamp = Carbon::now();

        if ($purchase->status == "order_complete" && $purchase->user_id == Auth()->user()->id) {
            $purchase->status = "customer_order_received";
            $purchase->status_notes = $purchase->status_notes . " (" . $time_stamp . ")  customer order received %%";

            $purchase->save();

            return [
                'status' => true,
                'message' => "customer_order_received",
                'id' => $purchase->id,
                'referenceId' => $purchase->referrence_id,
            ];
        } else {
            return [
                'status' => false,
                'message' => "this status cant be change by user",
                'id' => $purchase->id,
                'referenceId' => $purchase->referrence_id,
            ];

        }

    }

}