<?php

namespace App\Http\Controllers\Dashboard\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Model\Area;
use App\Model\City;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $areas = Area::with('city')->get();
        $cities = City::all();
        $selected = City::find(1);
        $selected->en = "all";
        $selected->ar = "الكل";

        return view('admin.settings.areas.index', compact('areas', 'cities', 'selected'));
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
        $area = new Area();
        $area->ar = $request->ar;
        $area->en = $request->en;
        $area->city_id = $request->city_id;
        $area->save();
        return redirect()->route('settings.areas.index')->with(['message' => __('lang.successfully_added')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $areas = Area::where('city_id', $id)->with('city')->get();
        $cities = City::all();
        $city = City::find($id);
        $selected = $city;
        return view('admin.settings.areas.index', compact('areas', 'cities', 'selected'));
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

        $area = Area::find($request->id);
        $area->ar = $request->ar;
        $area->en = $request->en;
        $area->city_id = $request->city_id;
        $area->save();
        return redirect()->route('settings.areas.index')->with(['message' => __('lang.successfully_updated')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $area = Area::find($id);
        $area->delete();
        return redirect()->route('settings.areas.index')->with(['message' => __('lang.successfully_deleted')]);
    }
}