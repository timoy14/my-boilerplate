<?php

namespace App\Http\Controllers\Dashboard\Admin\Users;

use App\Http\Controllers\Controller;
use App\Model\City;
use App\Model\Gender;
use App\Model\Purchase;
use App\Model\Review;
use App\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $customers = User::query();

        if (isset($request->search)) {
            $search = $request->search;
            $customers = $customers->where(function ($q) use ($search) {
                $q->orWhere('name', 'LIKE', "%$search%")
                    ->orWhere('email', 'LIKE', "%$search%");
            });
        }

        $customers = $customers->where("role_id",5)->orderBy('id', 'desc')->paginate(15);
        $paginator = $customers;

        return view('admin.users.customers.index', compact('customers','paginator'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $registration_status = ['pending', 'accepted', 'rejected'];
        $cities = City::all();
        $genders = Gender::all();
        return view('admin.users.customers.create', compact('genders', 'cities','registration_status'));
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
            'phone' => ['required', 'numeric', 'unique:users', 'min:10']
        ]);

        $user = new User();
        $user->role_id = 5;
        $user->gender_id = $request->gender;
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->activation_code = md5(12345);
        $user->is_verified = true;

        if (!empty($request->file)) {
            $filename = md5(uniqid()) . date('dmY') . '.' . $request->file->getClientOriginalExtension();
            $user->avatar = $request->file->storeAs('', $filename, 'public');
        }

        $user->save();

        return redirect()->route('admin-users.customers.index')->with(['message' => __('lang.successfully_added')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    
        $user = User::find($id);
        $cities = City::all();
        $genders = Gender::all();

        $orders = array();
    
        $months = ["january","february","march","april","may","june","july","august","september","october","november","december"];
        $year =  date("Y");

        foreach($months as $key => $month){
            $key = $key+1;
            $from = $year."-".($key)."-1 00:00:00";
            if ($key%2 == 1) {
                $to = $year."-".($key+1)."-30 00:00:00";
            }elseif($key%2 == 0) {
                $to = $year."-".($key+1)."-31 00:00:00";
            }

            $orders[$month] = Purchase::where("user_id",$user->id)->whereBetween('created_at', [$from, $to])->get()->count();
        }


        return view('admin.users.customers.show', compact('user', 'genders', 'cities','orders'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $cities = City::all();
        $genders = Gender::all();
        $registration_status = ['pending', 'accepted', 'rejected'];
        return view('admin.users.customers.edit', compact('user', 'genders', 'cities','registration_status'));
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
        $request->validate([
            'gender' => ['required', 'numeric'],
            'name' => 'required',
            'phone' => ['required', 'numeric', 'min:10'],
            'password' => ['confirmed'],
        ]);

        $user = User::find($id);
        $user->city_id = $request->city;
        $user->gender_id = $request->gender;
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        // $user->bank_name = $request->bank_name;
        // $user->bank_account_num = $request->bank_account_num;
        // $user->activation_code = $request->activation_code;
        // $user->language = $request->language;
        // $user->role_id = 5;
        // $user->address = $request->address;
        // $user->latitude = $request->latitude;
        // $user->longitude = $request->longitude;
        // $user->bio = $request->bio;
        // $user->default_user_address_id = $request->default_user_address_id;
        // $user->registration_status = $request->registration_status;
        // $user->registration_note = $request->registration_note;
        // $user->agreement_verify = $request->agreement_verify;
        // $user->is_verified = $request->is_verified;

        // if ($request->password) {
        //     $user->password = bcrypt($request->password);
        // }

        if (!empty($request->file)) {
            $filename = md5(uniqid()) . date('dmY') . '.' . $request->file->getClientOriginalExtension();
            $user->avatar = $request->file->storeAs('', $filename, 'public');
        }

        $user->save();

        return redirect()->route('admin-users.customers.index')->with(['message' => __('lang.successfully_updated')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->route('admin-users.customers.index')->with(['message' => __('lang.successfully_deleted')]);
    }


    public function purchase_index(Request $request, $user_id){
        $purchases = Purchase::query();


        $purchases = $purchases->where("user_id",$user_id)->paginate(15);
        for ($i=0; $i < count($purchases); $i++) { 
            $purchases[$i]->pharmacy_id = User::where("id",$purchases[$i]->pharmacy_id)->first();
            $purchases[$i]->driver_id = User::where("id",$purchases[$i]->driver_id)->first();
        }
        $paginator = $purchases;

        return view('admin.users.customers.purchase.index', compact('purchases','paginator'));
    }

    public function reviews_index(Request $request, $user_id){
        $Reviews = Review::query();

        $reviews = $Reviews->where("user_id",$user_id)->paginate(15);
        for ($i=0; $i < count($reviews); $i++) { 
            $reviews[$i]->user_id = User::where("id",$reviews[$i]->pharmacy_id)->first();
            $reviews[$i]->pharmacy_id = User::where("id",$reviews[$i]->pharmacy_id)->first();
            $reviews[$i]->driver_id = User::where("id",$reviews[$i]->driver_id)->first();
        }

        $paginator = $Reviews;

        return view('admin.users.customers.reviews.index', compact('reviews','paginator'));
    }
}