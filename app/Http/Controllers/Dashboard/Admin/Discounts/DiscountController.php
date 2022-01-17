<?php

namespace App\Http\Controllers\Dashboard\Admin\Discounts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Discount;
use App\User;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pharmacy_id = null;

        if(isset($request->pharmacy)){

            $discounts = Discount::where("user_id",$request->pharmacy)->with("user")->orderBy('id', 'DESC')->paginate(15);
            $pharmacy_id = $request->pharmacy;
        }elseif(isset($request->type)){
            $discounts = Discount::where("type",$request->type)->orderBy('id', 'DESC')->with("user")->paginate(15);
        }else{
            $discounts = Discount::orderBy('id', 'DESC')->with("user")->paginate(15);
        }

        $type = isset($request->type) ? $request->type : "";
        
        return view('admin.discounts.index', compact('discounts','pharmacy_id','type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $pharmacy_id = null;

        if(isset($request->pharmacy)){
            $pharmacy_id = $request->pharmacy;
        }

        $pharmacies = User::where("role_id",3)->where("registration_status","accepted")->get();
        $types = ['admin', 'pharmacy'];
        $type = isset($request->type) ? $request->type : "";
        return view('admin.discounts.create',compact('types','pharmacies','pharmacy_id','type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            "title" => "required",
            "code" => "required",
            "expiration_date" => "required",
            "type_dis" => "required",
            "capacity" => "required",
            "minimum_spend" => "required",
        ]);

        $discount = new Discount;
        $route_var = "";

        if(isset($request->pharmacy)){
            $discount->user_id = $request->pharmacy;
            $route_var = "pharmacy=".$request->pharmacy;
        }elseif(isset($request->pharmacy_id)){
            $discount->user_id = $request->pharmacy_id;
            $discount->type = "pharmacy";
        }else{
            $discount->user_id = 1;
            $discount->type = "admin";
        }

        $discount->title = $request->title;
        $discount->code = $request->code;
        $discount->expiration_date = $request->expiration_date;

        if($request->type_dis == "off"){
            $discount->off = $request->type_dis_off_value;
        }else{
            $discount->rate = $request->type_dis_off_value;
        }

        $discount->capacity = $request->capacity;
        $discount->minimum_spend = $request->minimum_spend;
        $discount->save();

        return redirect()->route('admin.discounts.index',$route_var)->with(['message' => __('lang.successfully_added')]);
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
        $discount = Discount::find($id);
      

        return view('admin.discounts.edit', compact('discount'));
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
        $discount =  Discount::find($id);

        $discount->title = $request->title;
        $discount->code = $request->code;
        $discount->expiration_date = $request->expiration_date;

        if($request->type_dis == "off"){
            $discount->off = $request->type_dis_off_value;
            $discount->rate = null;
        }else{
            $discount->rate = $request->type_dis_off_value;
            $discount->off = null;
        }

        $discount->capacity = $request->capacity;
        $discount->minimum_spend = $request->minimum_spend;
        $discount->save();

        return redirect()->route('admin.discounts.edit',$id)->with(['message' => __('lang.successfully_added')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dicount = Discount::find($id);
        $dicount->delete();
        return redirect()->route('admin.discounts.index')->with(['message' => __('lang.successfully_deleted')]);
    }
}
