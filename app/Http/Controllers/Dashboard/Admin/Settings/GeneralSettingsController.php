<?php

namespace App\Http\Controllers\Dashboard\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Model\Setting;
use Illuminate\Http\Request;

class GeneralSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $setting = Setting::first();
        return view('admin.settings.general-setting.index', compact('setting'));
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


        $setting = Setting::find($id);
        $setting->admin_commission = $request->admin_commission;
        $setting->driver_commission = $request->driver_commission;
        $setting->cancellation_time_limit = $request->cancellation_time_limit;
        $setting->tax_rate = $request->tax_rate;
        $setting->delivery_fee_less_than_5_km = $request->delivery_fee_less_than_5_km;
        $setting->delivery_fee_5_to_10_km = $request->delivery_fee_5_to_10_km;
        $setting->delivery_fee_more_than_10_km = $request->delivery_fee_more_than_10_km;
        
        $setting->save();

        return redirect()->route('settings.general-setting.index')->with(['message' => __('lang.successfully_updated')]);
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