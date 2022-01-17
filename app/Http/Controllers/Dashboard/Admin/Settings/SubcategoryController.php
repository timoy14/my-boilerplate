<?php

namespace App\Http\Controllers\Dashboard\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Model\Category;
use App\Model\Subcategory;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subcategories = Subcategory::with('category')->get();
        return view('admin.settings.subcategories.index', compact('subcategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.settings.subcategories.create', compact('categories'));
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

            'category_id' => 'required|numeric',
        ]);
        $subcategory = new Subcategory();

        $subcategory->ar = $request->ar;
        $subcategory->en = $request->en;

        $subcategory->description = $request->description;
        $subcategory->category_id = $request->category_id;
        if (!empty($request->icon)) {
            $filename = md5(uniqid()) . date('dmY') . '.' . $request->icon->getClientOriginalExtension();
            $subcategory->icon = $request->icon->storeAs('', $filename, 'public');
        }
        $subcategory->save();
        return redirect()->route('settings.subcategories.index')->with(['message' => __('lang.successfully_added')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $subcategory = Subcategory::find($id);
        $subcategory->display = !$subcategory->display;
        $subcategory->save();
        return redirect()->route('settings.subcategories.index')->with(['message' => __('lang.successfully_updated')]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subcategory = Subcategory::find($id);
        $categories = Category::all();
        return view('admin.settings.subcategories.edit', compact('subcategory', 'categories'));
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

            'category_id' => 'required|numeric',
        ]);
        $subcategory = Subcategory::find($id);

        $subcategory->ar = $request->ar;
        $subcategory->en = $request->en;

        $subcategory->description = $request->description;
        $subcategory->category_id = $request->category_id;
        if (!empty($request->icon)) {
            $filename = md5(uniqid()) . date('dmY') . '.' . $request->icon->getClientOriginalExtension();
            $subcategory->icon = $request->icon->storeAs('', $filename, 'public');
        }
        $subcategory->save();
        return redirect()->route('settings.subcategories.index')->with(['message' => __('lang.successfully_updated')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subcategory = Subcategory::find($id);
        $subcategory->delete();
        return redirect()->route('settings.subcategories.index')->with(['message' => __('lang.successfully_deleted')]);
    }
}