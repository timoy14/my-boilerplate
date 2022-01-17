<?php

namespace App\Http\Controllers\Dashboard\Admin\StaffPermissions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\StaffPermission;

class StaffPermissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $staffPermission = StaffPermission::first();
        return view('admin.settings.staffpermissions.index', compact('staffPermission'));
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
      $staffPermission = StaffPermission::find(1);
      $staffPermission->users = isset($request->users) ? $request->users : 0;
      $staffPermission->pharmacies = isset($request->pharmacies) ? $request->pharmacies : 0;
      $staffPermission->orders = isset($request->orders) ? $request->orders : 0;
      $staffPermission->discounts = isset($request->discounts) ? $request->discounts : 0;
      $staffPermission->notifications = isset($request->notifications) ? $request->notifications : 0;
      $staffPermission->payments = isset($request->payments) ? $request->payments : 0;
      $staffPermission->products = isset($request->products) ? $request->products : 0;
      $staffPermission->settings = 0;
      $staffPermission->save();

      return redirect()->route("staffpermissions.staffpermissions.index")->with(['message' => __('lang.successfully_updated')]);
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
