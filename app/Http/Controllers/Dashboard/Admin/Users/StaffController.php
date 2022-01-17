<?php

namespace App\Http\Controllers\Dashboard\Admin\Users;

use App\Services\CloudinaryFileUpload;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Model\City;
use App\Model\Gender;
use App\Model\File;
use App\Model\StaffPermission;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $staffs = User::query();

        if (isset($request->search)) {
            $search = $request->search;
            $staffs = $staffs->where(function ($q) use ($search) {
                $q->orWhere('name', 'LIKE', "%$search%")
                    ->orWhere('email', 'LIKE', "%$search%");
            });
        }

        $staffs = $staffs->where("role_id",2)->orderBy('id', 'desc')->paginate(15);
        $paginator = $staffs;

        return view('admin.users.staffs.index', compact('staffs','paginator'));
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
        return view('admin.users.staffs.create', compact('genders', 'cities'));
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
            'name' => 'required',
            'phone' => ['required', 'numeric', 'unique:users', 'min:10'],
            'password' => ['required', 'confirmed', 'min:6'],
        ]);

        $user = new User();
        $user->role_id = 2;
        $user->city_id = $request->city;
        $user->gender_id = $request->gender;
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->password = bcrypt($request->password);
        $user->bank_name = $request->bank_name;
        $user->email = $request->email;
        $user->bank_account_num = $request->bank_account_num;
        $user->activation_code = md5(12345);
        $user->is_verified = true;
        $user->save();



        if ($request->hasFile('file')) {
            $cloudinaryFileUpload = new CloudinaryFileUpload();

            $File = new File();
            $file_uploaded = $request->file('file');
            $File->file = $cloudinaryFileUpload->file_upload($file_uploaded,'products');
            $File->user_id = $user->id;
            $File->save();
        }

        $staffPermission = new StaffPermission;
        $staffPermission->user_id = $user->id;
        $staffPermission->users = isset($request->users) ? $request->users : 0;
        $staffPermission->pharmacies = isset($request->pharmacies) ? $request->pharmacies : 0;
        $staffPermission->orders = isset($request->orders) ? $request->orders : 0;
        $staffPermission->discounts = isset($request->discounts) ? $request->discounts : 0;
        $staffPermission->notifications = isset($request->notifications) ? $request->notifications : 0;
        $staffPermission->payments = isset($request->payments) ? $request->payments : 0;
        $staffPermission->products = isset($request->products) ? $request->products : 0;
        $staffPermission->settings = 0;
        $staffPermission->save();
  


        return redirect()->route('admin-users.staffs.index')->with(['message' => __('lang.successfully_added')]);
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
        $staffPermission = StaffPermission::where("user_id",$id)->first();
        $cities = City::all();
        $genders = Gender::all();
        return view('admin.users.staffs.show', compact('user', 'genders', 'cities','staffPermission'));
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
        $staffPermission = StaffPermission::where("user_id",$id)->first();
        return view('admin.users.staffs.edit', compact('user', 'genders', 'cities','staffPermission'));
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

        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        if (!empty($request->file)) {
            $filename = md5(uniqid()) . date('dmY') . '.' . $request->file->getClientOriginalExtension();
            $user->avatar = $request->file->storeAs('', $filename, 'public');
        }

        $user->save();

        StaffPermission::updateOrCreate(
            [
               'user_id' => $id,
            ],
            [
                'users' => isset($request->users) ? $request->users : 0,
                'pharmacies' => isset($request->pharmacies) ? $request->pharmacies : 0,
                'orders' => isset($request->orders) ? $request->orders : 0,
                'discounts' => isset($request->discounts) ? $request->discounts : 0,
                'notifications' => isset($request->notifications) ? $request->notifications : 0,
                'payments' => isset($request->payments) ? $request->payments : 0,
                'products' => isset($request->products) ? $request->products : 0,
                'settings' => 0,
            ],
        );

        return redirect()->route('admin-users.staffs.index')->with(['message' => __('lang.successfully_updated')]);
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
        return redirect()->route('admin-users.staffs.index')->with(['message' => __('lang.successfully_deleted')]);
    }
}
