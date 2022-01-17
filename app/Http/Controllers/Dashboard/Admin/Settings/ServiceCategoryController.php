<?php

namespace App\Http\Controllers\Dashboard\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Model\Category;
use App\Model\ServiceCategory;
use Illuminate\Http\Request;

class ServiceCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $service_categories = ServiceCategory::with('category')->get();
        return view('admin.settings.service-categories.index', compact('service_categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.settings.service-categories.create', compact('categories'));
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
            'ar' => 'required',
            'en' => 'required',

            'description' => 'required',
            'category_id' => 'required|numeric',
        ]);
        $service_category = new ServiceCategory();

        $service_category->ar = $request->ar;
        $service_category->en = $request->en;

        $service_category->description = $request->description;
        $service_category->category_id = $request->category_id;
        if (!empty($request->icon)) {
            $filename = md5(uniqid()) . date('dmY') . '.' . $request->icon->getClientOriginalExtension();
            $service_category->icon = $request->icon->storeAs('', $filename, 'public');
        }
        $service_category->save();
        return redirect()->route('settings.service-categories.index')->with(['message' => __('lang.successfully_added')]);
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
        $service_category = ServiceCategory::find($id);
        $categories = Category::all();
        return view('admin.settings.service-categories.edit', compact('categories', 'service_category'));
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
            'ar' => 'required',
            'en' => 'required',

            'description' => 'required',
            'category_id' => 'required|numeric',
        ]);
        $service_category = ServiceCategory::find($id);

        $service_category->ar = $request->ar;
        $service_category->en = $request->en;

        $service_category->description = $request->description;
        $service_category->category_id = $request->category_id;
        if (!empty($request->icon)) {
            $filename = md5(uniqid()) . date('dmY') . '.' . $request->icon->getClientOriginalExtension();
            $service_category->icon = $request->icon->storeAs('', $filename, 'public');
        }
        $service_category->save();
        return redirect()->route('settings.service-categories.index')->with(['message' => __('lang.successfully_updated')]);
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