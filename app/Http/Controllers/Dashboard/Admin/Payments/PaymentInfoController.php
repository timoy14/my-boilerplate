<?php

namespace App\Http\Controllers\Dashboard\Admin\Payments;

use App\Http\Controllers\Controller;
use App\Model\Purchase;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Model\Payment;
use App\Services\CloudinaryFileUpload;

class PaymentInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        // $phar
        $data = array();
        $purchases_data = array();
        $user = User::find($request->id);

        if($user->role_id == 3){
                $purchases_data["unpaid"] = DB::table('purchases')
                                                    ->whereIn("status",["order_complete"])
                                                    ->where("pharmacy_id",$request->id)
                                                    ->where("pharmacy_payment_id",null)
                                                    ->select(
                                                            DB::raw("count(id) as order_count"),
                                                            DB::raw("sum(sub_total) as total_amount"),
                                                            DB::raw("sum(admin_commission) as total_admin_commission"),
                                                            DB::raw("DATE_FORMAT(created_at, '%M-%Y') as month"),
                                                            )
                                                    ->orderBy('month')
                                                    ->groupBy('month')
                                                    ->paginate(15);

                $purchases_data["paid"] = DB::table('payments')
                                                    ->where("user_id",$user->id)
                                                    ->paginate(15);
        }else{

            $purchases_data["unpaid"] = DB::table('purchases')
                                                    ->whereIn("status",["order_complete"])
                                                    ->where("driver_id",$request->id)
                                                    ->where("driver_payment_id",null)
                                                    ->select(
                                                            DB::raw("count(id) as order_count"),
                                                            DB::raw("sum(delivery_fee) as total_amount"),
                                                            DB::raw("sum(driver_commission) as total_admin_commission"),
                                                            DB::raw("DATE_FORMAT(created_at, '%M-%Y') as month"))
                                                    ->orderBy('month')
                                                    ->groupBy('month')
                                                    ->get();

                $purchases_data["paid"] = DB::table('payments')
                                                    ->where("user_id",$user->id)
                                                    ->paginate(15);
        }
        

        $data["payments"] = $purchases_data;
        $data["tab"] = "unpaid";

        return view('admin.payments.payments_info.index',compact('data','user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {   
        $user_id = $request->id;
        $unpaid_month = Purchase::query();
        $unpaid_month = $unpaid_month->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->get();

      

        return view('admin.payments.payments_info.create',compact('user_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // echo "<pre>";
        // print_r($request->file('attachment'));
        // echo "</pre>";
        // die();

        $user = User::find($request->user);

        $payment = new Payment;
        $payment->month = $request->thismonth_month;
        $payment->year = $request->thismonth_year;
        $payment->total_amount = $request->total_amount;
        $payment->admin_commission = $request->admin_commission;
        $payment->user_earning = $request->total_amount-$request->admin_commission;
        $payment->user_id = $user->id;
        $payment->order_count = $request->order_count;
        $payment->transaction_number = $request->transaction_number;


        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $cloudinaryFileUpload = new CloudinaryFileUpload();
            $payment->attachement = $cloudinaryFileUpload->file_upload($file, 'payments');
        }

        $payment->save();


        if($user->role_id == 3){
            $posts = Purchase::whereYear('created_at', '=', $request->thismonth_year)
                            ->whereMonth('created_at', '=', $request->thismonth_month)
                            ->whereIn("status",["order_complete"])
                            ->where('pharmacy_id', $user->id)
                            ->where('pharmacy_payment_id', null)
                            ->update(
                                [
                                    'pharmacy_payment_id' => $payment->id,
                                ]
                            );

        }


        if($user->role_id == 4){
            $posts = Purchase::whereYear('created_at', '=', $request->thismonth_year)
                            ->whereMonth('created_at', '=', $request->thismonth_month)
                            ->whereIn("status",["order_complete"])
                            ->where('driver_id', $user->id)
                            ->where('driver_payment_id', null)
                            ->update(
                                [
                                    'driver_payment_id' => $payment->id,
                                ]
                            );

        }

        return redirect()->route('admin.payments-info.index',"id=".$user->id)->with(['message' => __('lang.successfully_added')]);

                        
        
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
