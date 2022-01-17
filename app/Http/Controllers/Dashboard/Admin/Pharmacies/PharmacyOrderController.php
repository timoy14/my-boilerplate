<?php

namespace App\Http\Controllers\Dashboard\Admin\Pharmacies;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Model\City;
use App\Model\Discount;
use App\Model\Gender;
use App\Model\Purchase;

class PharmacyOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     /**
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $completed = Purchase::query();
        $pharmacy_id = $id;
        
        $orders["completed"] = $completed->where("pharmacy_id",$pharmacy_id)->orderBy('id', 'desc')->paginate(15);
        $data["orders"] = $orders;
        $data["tab"] = "completed";

        return view('admin.pharmacies.orders.index', compact('data','pharmacy_id'));
    }

    /**
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($pharmacy_id,$order_id)
    {

        $order = Purchase::find($order_id);
        if (isset($order->driver_id)) {
            $order->driver_id = User::find($order->driver_id);
        }
        if (isset($order->discount_id)) {
            $order->discount_id = Discount::find($order->discount_id);
        }

        return view('admin.pharmacies.orders.show', compact('order','pharmacy_id','order_id'));
    }

        /**
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($pharmacy_id,$order_id)
    {

        $order = Purchase::find($order_id);
        if (isset($order->driver_id)) {
            $order->driver_id = User::find($order->driver_id);
        }
        if (isset($order->discount_id)) {
            $order->discount_id = Discount::find($order->discount_id);
        }

        $drivers = User::where("role_id",4)->get();
        $discounts = Discount::get();
        $status = ['order_received','preparing_order','in_transit','order_complete','cancelled','payment'];

        return view('admin.pharmacies.orders.edit', compact('order','pharmacy_id','order_id','drivers','discounts','status'));
    }

    public function update(Request $request,$pharmacy_id,$order_id)
    {
        $purchase = Purchase::find($order_id);
        $purchase->driver_id = $request->driver_id;
        $purchase->status = $request->status;
        $purchase->tax_amount = $request->tax_amount;
        $purchase->sub_total = $request->sub_total;
        $purchase->total_amount = $request->total_amount;
        $purchase->delivery_fee = $request->delivery_fee;
        $purchase->driver_commission = $request->driver_commission;
        $purchase->admin_commission = $request->admin_commission;
        $purchase->save();

        return redirect()->route('admin.pharmacies.orders-edit',[$pharmacy_id,$order_id])->with(['message' => __('lang.successfully_updated')]);
    } 

    public function destroy($pharmacy_id,$order_id)
    {
        
        $purchase = Purchase::find($order_id);
        $purchase->delete();

        return redirect()->route('admin.pharmacies.orders-index',$pharmacy_id)->with(['message' => __('lang.successfully_updated')]);
    } 
}
