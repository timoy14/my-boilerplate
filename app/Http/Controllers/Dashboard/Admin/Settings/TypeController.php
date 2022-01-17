<?php

namespace App\Http\Controllers\Dashboard\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Model\Category;
use App\Model\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types = Type::all();
        $categories = Category::all();
        $selected = Category::find(1);
        $selected->en = 'All';
        $selected->ar = 'الكل';
        return view('admin.settings.types.index', compact('types', 'categories', 'selected'));
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
        $type = new Type();
        $type->category_id = $request->category;
        $type->ar = $request->ar;
        $type->en = $request->en;
        $type->save();

        return redirect()->route('settings.types.show', $request->category)->with(['message' => __('lang.successfully_added')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $types = Type::where('category_id', $id)->with('category')->get();

        $category = Category::find($id);
        $categories = Category::all();
        $selected = $category;

        return view('admin.settings.types.index', compact('types', 'categories', 'selected'));
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

        $type = Type::find($request->id);
        $type->category_id = $request->category;
        $type->ar = $request->ar;
        $type->en = $request->en;
        $type->save();
        return redirect()->route('settings.types.show', $request->category)->with(['message' => __('lang.successfully_updated')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $type = Type::find($id);
        $type->delete();
        return redirect()->route('settings.types.index')->with(['message' => __('lang.successfully_deleted')]);
    }
}