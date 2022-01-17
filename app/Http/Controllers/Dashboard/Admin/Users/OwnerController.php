<?php

namespace App\Http\Controllers\Dashboard\Admin\Users;

use App\Http\Controllers\Controller;
use App\Model\City;
use App\Model\Gender;
use App\User;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $owners = User::whereHas('role', function ($q) {
            $q->where('id', 3);
        })->orderBy('id', 'desc')->orderBy('id', 'desc')->get();

        return view('admin.users.owners.index', compact('owners'));
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
        return view('admin.users.owners.create', compact('genders', 'cities'));
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

        if (!empty($request->file)) {
            $filename = md5(uniqid()) . date('dmY') . '.' . $request->file->getClientOriginalExtension();
            $user->avatar = $request->file->storeAs('', $filename, 'public');
        }

        $user->save();

        return redirect()->route('users.owners.index')->with(['message' => __('lang.successfully_added')]);
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
        return view('admin.users.owners.show', compact('user', 'genders', 'cities'));
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
        return view('admin.users.owners.edit', compact('user', 'genders', 'cities'));
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
        $user->bank_name = $request->bank_name;
        $user->bank_account_num = $request->bank_account_num;

        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        if (!empty($request->file)) {
            $filename = md5(uniqid()) . date('dmY') . '.' . $request->file->getClientOriginalExtension();
            $user->avatar = $request->file->storeAs('', $filename, 'public');
        }

        $user->save();

        return redirect()->route('users.owners.index')->with(['message' => __('lang.successfully_updated')]);
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
        return redirect()->route('users.owners.index')->with(['message' => __('lang.successfully_deleted')]);
    }
}