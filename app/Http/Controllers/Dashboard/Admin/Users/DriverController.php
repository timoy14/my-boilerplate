<?php

namespace App\Http\Controllers\Dashboard\Admin\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Model\City;
use App\Model\Gender;
use App\Model\Purchase;
use App\Services\CloudinaryFileUpload;

class DriverController extends Controller
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
        $rejected = User::query();

        $data = array();
        $drivers = array();

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
            $rejected = $rejected->where(function ($q) use ($search) {
                $q->orWhere('pharmacy_name', 'LIKE', "%$search%")
                    ->orWhere('email', 'LIKE', "%$search%");
            });
        }

        $drivers["accepted"] = $accepted->where("registration_status","accepted")->where("role_id",4)->orderBy('id', 'desc')->paginate(15);
        $drivers["pending"] = $pending->where("registration_status","pending")->where("role_id",4)->orderBy('id', 'desc')->paginate(15);
        $drivers["rejected"] = $rejected->where("registration_status","rejected")->where("role_id",4)->orderBy('id', 'desc')->paginate(15);
        $data["drivers"] = $drivers;
        if (isset($request->tab)) {
            $data["tab"] = $request->tab;
        }else{
            $data["tab"] = "pending";
        }

        return view('admin.users.drivers.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cities = City::all();
        $genders = Gender::all();
        return view('admin.users.drivers.create', compact('genders', 'cities'));
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
            'city' => ['required', 'numeric'],
            'gender' => ['required', 'numeric'],
            'name' => 'required',
            'email' => 'email',
            'phone' => ['required', 'numeric', 'unique:users', 'min:10'],
            'password' => ['required', 'confirmed', 'min:6'],
        ]);

        $user = new User();
        $user->role_id = 4;
        $user->city_id = $request->city;
        $user->gender_id = $request->gender;
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->activation_code = md5(12345);
        $user->is_verified = true;

        // if (!empty($request->file)) {
        //     $filename = md5(uniqid()) . date('dmY') . '.' . $request->file->getClientOriginalExtension();
        //     $user->avatar = $request->file->storeAs('', $filename, 'public');
        // }

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $cloudinaryFileUpload = new CloudinaryFileUpload();
            $user->avatar = $cloudinaryFileUpload->file_upload($file, 'avatar');
        }

        $user->save();

        return redirect()->route('admin-users.drivers.index')->with(['message' => __('lang.successfully_added')]);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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

            $orders[$month] = Purchase::where("user_id",$id)->whereBetween('created_at', [$from, $to])->get()->count();
        }

        $user = User::find($id);
        $cities = City::all();
        $genders = Gender::all();
        return view('admin.users.drivers.show', compact('user', 'genders', 'cities','orders'));
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
        return view('admin.users.drivers.edit', compact('user', 'genders', 'cities','registration_status'));
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
            'city' => ['required', 'numeric'],
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
        // $user->role_id = 4;
        $user->address = $request->address;
        $user->latitude = $request->latitude;
        $user->longitude = $request->longitude;
        // $user->bio = $request->bio;

        if(isset($request->registration_status)){
            $user->registration_status = $request->registration_status;
            $user->registration_note = $request->registration_note;
        }

        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $cloudinaryFileUpload = new CloudinaryFileUpload();
            $user->avatar = $cloudinaryFileUpload->file_upload($file, 'avatar');
        }
        

        $user->save();

        return redirect()->route('admin-users.drivers.index')->with(['message' => __('lang.successfully_updated')]);
    }
    public function update_registration_status(Request $request, $id)
    {
        $request->validate([
            'registration_status' => ['required']
        ]);

        // print_r($request->input());
        // die();
        if(isset($request->driver_id)){
            $user = User::find($request->driver_id);
        }else{
            $user = User::find($id);
        }
        
        $user->registration_status = $request->registration_status;
        $user->registration_note = $request->registration_note;
        $user->save();

        return redirect()->route('admin-users.drivers.index')->with(['message' => __('lang.successfully_updated')]);
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
        return redirect()->route('admin-users.drivers.index')->with(['message' => __('lang.successfully_deleted')]);
    }
}
