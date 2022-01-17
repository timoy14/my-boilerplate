<?php

namespace App\Http\Controllers\Dashboard\Admin\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Model\City;
use App\Model\Gender;
use App\Model\Purchase;

class PharmacyControllersss extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $accepted = User::query();
        $pending = User::query();

        $data = array();
        $clients = array();

        if (isset($request->search)) {
            $search = $request->search;
            $accepted = $accepted->where(function ($q) use ($search) {
                $q->orWhere('pharmacy_name', 'LIKE', "%$search%")
                    ->orWhere('email', 'LIKE', "%$search%");
            });
            $pending = $pending->where(function ($q) use ($search) {
                $q->orWhere('pharmacy_name', 'LIKE', "%$search%")
                    ->orWhere('email', 'LIKE', "%$search%");
            });
        }

        $clients["accepted"] = $accepted->where("registration_status","accepted")->paginate(15);
        $clients["pending"] = $pending->where("registration_status","pending")->paginate(15);
        $data["pharmacies"] = $clients;
        if (isset($request->tab)) {
            $data["tab"] = $request->tab;
        }else{
            $data["tab"] = "pending";
        }
 
        return view('admin.pharmacies.index', compact('data'));
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
        $user = User::find($id);
        $cities = City::all();
        $genders = Gender::all();
        return view('admin.pharmacies.show', compact('user', 'genders', 'cities'));
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
        return view('admin.pharmacies.edit', compact('user', 'genders', 'cities'));
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
        // $request->validate([
        //     'city' => ['required', 'numeric'],
        //     'gender' => ['required', 'numeric'],
        //     'name' => 'required',
        //     'phone' => ['required', 'numeric', 'min:10'],
        //     'password' => ['confirmed'],
        // ]);

        // $user = User::find($id);
        // $user->city_id = $request->city;
        // $user->gender_id = $request->gender;
        // $user->name = $request->name;
        // $user->phone = $request->phone;
        // $user->email = $request->email;
        // $user->bank_name = $request->bank_name;
        // $user->bank_account_num = $request->bank_account_num;

        // if ($request->password) {
        //     $user->password = bcrypt($request->password);
        // }

        // if (!empty($request->file)) {
        //     $filename = md5(uniqid()) . date('dmY') . '.' . $request->file->getClientOriginalExtension();
        //     $user->avatar = $request->file->storeAs('', $filename, 'public');
        // }

        // $user->save();

        // return redirect()->route('admin.pharmacies.index')->with(['message' => __('lang.successfully_updated')]);
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
        return redirect()->route('admin.pharmacies.index')->with(['message' => __('lang.successfully_deleted')]);
    }

        /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function orders_index($id)
    {
        $completed = Purchase::query();
        $pharmacy_id = $id;
        
        $orders["completed"] = $completed->paginate(15);
        $data["orders"] = $orders;
        $data["tab"] = "completed";

        return view('admin.pharmacies.orders.index', compact('data','pharmacy_id'));
    }
}
