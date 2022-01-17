<?php

namespace App\Http\Controllers\Dashboard\Admin\Payments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Purchase;
use App\Model\Setting;
use App\Model\Payment;
use App\User;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $tab = "pharmacies";
        if($request->has("type") && $request->type == "pharmacy"){
            $pharmacy = User::query();

            $orders_data["pharmacies"] = $pharmacy->whereHas("pharmacy_purchases",function ($query) {
                                                    $query->whereIn("status",["order_complete"]);
                                                 })
                                                 ->orderBy('id', 'desc')
                                                 ->paginate(15);
                                                 
        }elseif($request->has("type") && $request->type == "driver"){
                                                    
            $driver = User::query();
            $tab = "drivers";
            $orders_data["drivers"] = $driver->whereHas("deliveries",function ($query) {
                                                    $query->whereIn("status",["order_complete"]);
                                                })
                                                ->orderBy('id', 'desc')
                                                ->paginate(15);
            // die();
        }

        $data["payments"] = $orders_data;
        $data["tab"] = $tab;

        return view('admin.payments.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
