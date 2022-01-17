<?php

namespace App\Http\Controllers\Dashboard\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Model\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities = City::all();
        return view('admin.settings.cities.index', compact('cities'));
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
        $city = new City();
        $city->ar = $request->ar;

        $city->en = $request->en;

        if ($request->en_1) {
            $city->en_1 = $request->en_1;
        }
        if ($request->ar_1) {

            $city->ar_1 = $request->ar_1;
        }
        if ($request->ar_2) {
            $city->ar_2 = $request->ar_2;
        }
        if ($request->ar_3) {

            $city->ar_3 = $request->ar_3;
        }

        $city->save();
        return redirect()->route('settings.cities.index')->with(['message' => __('lang.successfully_added')]);
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

        $city = City::find($request->id);
        $city->ar = $request->ar;
        $city->en = $request->en;
        if ($request->en_1) {
            $city->en_1 = $request->en_1;
        }
        if ($request->ar_1) {

            $city->ar_1 = $request->ar_1;
        }
        if ($request->ar_2) {
            $city->ar_2 = $request->ar_2;
        }
        if ($request->ar_3) {

            $city->ar_3 = $request->ar_3;
        }

        $city->save();
        return redirect()->route('settings.cities.index')->with(['message' => __('lang.successfully_updated')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $city = City::find($id);
        $city->delete();
        return redirect()->route('settings.cities.index')->with(['message' => __('lang.successfully_deleted')]);
    }
}