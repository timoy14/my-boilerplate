<?php

namespace App\Http\Controllers\Dashboard\Admin\Pharmacies;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Model\City;
use App\Model\Discount;
use App\Model\Gender;
use App\Model\Purchase;
use App\Services\CloudinaryFileUpload;

class PharmacyController extends Controller
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
            $rejected = $rejected->where(function ($q) use ($search) {
                $q->orWhere('pharmacy_name', 'LIKE', "%$search%")
                    ->orWhere('email', 'LIKE', "%$search%");
            });
        }

        $clients["accepted"] = $accepted->where("registration_status","accepted")->where("role_id",3)->orderBy('id', 'desc')->paginate(15);
        $clients["pending"] = $pending->where("registration_status","pending")->where("role_id",3)->orderBy('id', 'desc')->paginate(15);
        $clients["rejected"] = $rejected->where("registration_status","rejected")->where("role_id",3)->orderBy('id', 'desc')->paginate(15);
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
        $cities = City::all();
        $genders = Gender::all();
        return view('admin.pharmacies.create', compact('genders', 'cities'));
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
            'pharmacy_name' => 'required',
            'phone' => ['required', 'numeric', 'unique:users', 'min:10'],
            'password' => ['required', 'confirmed', 'min:6'],
        ]);

        $user = new User();
        $user->role_id = 3;
        $user->city_id = $request->city;
        $user->pharmacy_name = $request->pharmacy_name;
        $user->phone = $request->phone;
        $user->password = bcrypt($request->password);
        $user->address = $request->address;
        $user->latitude = $request->latitude;
        $user->longitude = $request->longitude;
        // $user->bank_name = $request->bank_name;
        $user->email = $request->email;
        // $user->bank_account_num = $request->bank_account_num;
        $user->activation_code = md5(12345);
        $user->is_verified = true;

        // if (!empty($request->file)) {
        //     $filename = md5(uniqid()) . date('dmY') . '.' . $request->file->getClientOriginalExtension();
        //     $user->avatar = $request->file->storeAs('', $filename, 'public');
        // }
        $cloudinaryFileUpload = new CloudinaryFileUpload();
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $user->avatar = $cloudinaryFileUpload->file_upload($file, 'avatar');
        }

        if ($request->hasFile('pharmacy_avatar')) {
            $file = $request->file('pharmacy_avatar');
            $user->pharmacy_avatar = $cloudinaryFileUpload->file_upload($file, 'pharmacy');
        }

        if ($request->hasFile('valid_id_picture')) {
            $file = $request->file('valid_id_picture');
            $user->valid_id_picture = $cloudinaryFileUpload->file_upload($file, 'valid_id_picture');
        }

        $user->save();

        return redirect()->route('admin.pharmacies.index')->with(['message' => __('lang.successfully_added')]);
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

        return view('admin.pharmacies.show', compact('user', 'genders', 'cities','orders'));
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

        // echo "<pre>";
        // print_r($user);
        // echo "</pre>";
        $cities = City::all();
        $genders = Gender::all();

        $register_status = ['pending','accepted','rejected'];
        return view('admin.pharmacies.edit', compact('user', 'genders', 'cities','register_status'));
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
            'pharmacy_name' => 'required',
            'phone' => ['required', 'numeric', 'min:10'],
            'password' => ['confirmed'],
        ]);

        $user = User::find($id);
        $user->city_id = $request->city;
        $user->pharmacy_name = $request->pharmacy_name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->bank_name = $request->bank_name;
        $user->bank_account_num = $request->bank_account_num;
        $user->address = $request->address;
        $user->latitude = $request->latitude;
        $user->longitude = $request->longitude;
        
        if ($request->pasregistration_statussword) {
            $user->registration_status = $request->registration_status;
        }
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        // if (!empty($request->file)) {
        //     $filename = md5(uniqid()) . date('dmY') . '.' . $request->file->getClientOriginalExtension();
        //     $user->avatar = $request->file->storeAs('', $filename, 'public');
        // }
        $cloudinaryFileUpload = new CloudinaryFileUpload();
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $user->avatar = $cloudinaryFileUpload->file_upload($file, 'avatar');
        }

        if ($request->hasFile('pharmacy_avatar')) {
            $file = $request->file('pharmacy_avatar');
            $user->pharmacy_avatar = $cloudinaryFileUpload->file_upload($file, 'pharmacy');
        }

        if ($request->hasFile('valid_id_picture')) {
            $file = $request->file('valid_id_picture');
            $user->valid_id_picture = $cloudinaryFileUpload->file_upload($file, 'valid_id_picture');
        }

        $user->save();

        return redirect()->route('admin.pharmacies.index')->with(['message' => __('lang.successfully_updated')]);
    }

        /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function accept_pharmacy(Request $request)
    {
        $request->validate([
            'pharmacy_id' => ['required', 'numeric'],
        ]);

        $user = User::find($request->pharmacy_id);
        if(isset($request->status)){
            $user->registration_status = $request->status;
        }else{
            $user->registration_status = "accepted";
        }
        $user->registration_note = $request->registration_note;
        $user->save();
        return redirect()->route('admin.pharmacies.index')->with(['message' => __('lang.successfully_accepted')]);
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



}
