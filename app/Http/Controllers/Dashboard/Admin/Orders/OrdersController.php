<?php

namespace App\Http\Controllers\Dashboard\Admin\Orders;

use App\Http\Controllers\Controller;
use App\Model\Purchase;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\FirebaseRealtimeDatabase;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if($request->unpaid){

            $user = User::find($request->unpaid);
            $role = "pharmacy_id";
            $role_payment = "pharmacy_payment_id";
            if($user->role_id == 4){
                $role = "driver_id";
                $role_payment = "driver_payment_id";
            }
            
            $orders = Purchase::query();
            $orders_data["orders"] = $orders->whereIn("status",["order_complete"])
                                            ->where($role,$user->id)
                                            ->where($role_payment,null)
                                            ->whereMonth("created_at",$request->month)
                                            ->whereYear("created_at",$request->year)
                                            ->orderBy('id', 'DESC')->paginate(15);
            $data["orders"] = $orders_data;
            $data["tab"] = "orders";
    
            $paginator = $orders;
            return view('admin.orders.index', compact('orders','data','paginator'));
        }


        if($request->paid){

            $orders = Purchase::query();
            $orders_data["orders"] = $orders->whereIn("status",["order_complete"])
                                            ->whereMonth("created_at",$request->month)
                                            ->whereYear("created_at",$request->year)
                                            ->orderBy('id', 'DESC')->paginate(15);
            $data["orders"] = $orders_data;
            $data["tab"] = "orders";
    
            $paginator = $orders;
            return view('admin.orders.index', compact('orders','data','paginator'));
        }

        $orders_data = array();
        $orders_pre = Purchase::query();
        $orders_acc = Purchase::query();
        $orders_com = Purchase::query();
        $orders_can = Purchase::query();
        if ($request->search) {
            $search = $request->search;
            $orders = $orders->where(function ($q) use ($search) {
                // $q->orWhere('trade_name', 'LIKE', "%$search%")
                //     ->orWhere('trade_name_arabic', 'LIKE', "%$search%")
                //     ->orWhere('scientific_name', 'LIKE', "%$search%")
                //     ->orWhere('scientific_name_arabic', 'LIKE', "%$search%");
            });
        }
        
        
        $orders_data["order_prepared"] = $orders_pre->where("status","order_prepared")->orderBy('id', 'DESC')->paginate(15);
        $orders_data["accepted"] = $orders_acc->where("status","accepted")->orderBy('id', 'DESC')->paginate(15);
        $orders_data["order_completed"] = $orders_com->where("status","order_completed")->orderBy('id', 'DESC')->paginate(15);
        $orders_data["cancelled"] = $orders_can->where("status","cancelled")->orderBy('id', 'DESC')->paginate(15);
        $data["orders"] = $orders_data;
        $data["tab"] = "order_prepared";

        // $paginator = $orders;
        return view('admin.orders.index', compact('data'));
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
        $order = Purchase::find($id);
        // if (isset(File::where('pharmacy_product_id',$id)->orderBy('id', 'desc')->first()->file)) {
        //     $product->avatar = File::where('pharmacy_product_id',$id)->orderBy('id', 'desc')->first()->file;
        // }

        return view('admin.orders.edit', compact('order'));
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
        if ($request->status) {
            $booking = Purchase::find($id);
            $status = $booking->status;
            $booking->status = $request->status;      
            
            DB::beginTransaction();
            try {
                $booking->save();
                $FirebaseRealtimeDatabase = new FirebaseRealtimeDatabase;
                $FirebaseRealtimeDatabase->insert_data($id,"orders"); 
            } catch(\Exception $e)
            {
                DB::rollback();
                return redirect()->to($request->return_type)->with(['error' => __('lang.not_successfully_updated'), 'id' => $id]);
            }

            DB::commit();
        }
        return redirect()->to($request->return_type)->with(['message' => __('lang.successfully_updated'), 'id' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $purchase = Purchase::find($id);
        $purchase->delete();


        return redirect()->route('admin.orders.index')->with(['message' => __('lang.successfully_deleted')]);

    }
}
