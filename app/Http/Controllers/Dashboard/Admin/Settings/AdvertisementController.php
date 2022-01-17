<?php

namespace App\Http\Controllers\Dashboard\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Model\Advertisement;
use App\Model\Category;
use Illuminate\Http\Request;

class AdvertisementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $advertisements = Advertisement::with('category')->get();
        return view('admin.settings.advertisements.index', compact('advertisements'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.settings.advertisements.create', compact('categories'));
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
            'display' => 'required|numeric',
            'description' => 'required',
            'category_id' => 'required|numeric',
        ]);
        $advertisement = new Advertisement();

        $advertisement->ar = $request->ar;
        $advertisement->en = $request->en;
        $advertisement->display = $request->display;
        $advertisement->description = $request->description;
        $advertisement->category_id = $request->category_id;
        if (!empty($request->image)) {
            $filename = md5(uniqid()) . date('dmY') . '.' . $request->image->getClientOriginalExtension();
            $advertisement->image = $request->image->storeAs('', $filename, 'public');
        }
        $advertisement->save();
        return redirect()->route('settings.advertisements.index')->with(['message' => __('lang.successfully_added')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $advertisement = Advertisement::find($id);
        $advertisement->display = !$advertisement->display;
        $advertisement->save();
        return redirect()->route('settings.advertisements.index')->with(['message' => __('lang.successfully_updated')]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $advertisement = Advertisement::find($id);
        $categories = Category::all();
        return view('admin.settings.advertisements.edit', compact('advertisement', 'categories'));
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
            'display' => 'required|numeric',
            'description' => 'required',
            'category_id' => 'required|numeric',
        ]);
        $advertisement = Advertisement::find($id);

        $advertisement->ar = $request->ar;
        $advertisement->en = $request->en;
        $advertisement->display = $request->display;
        $advertisement->description = $request->description;
        $advertisement->category_id = $request->category_id;
        if (!empty($request->image)) {
            $filename = md5(uniqid()) . date('dmY') . '.' . $request->image->getClientOriginalExtension();
            $advertisement->image = $request->image->storeAs('', $filename, 'public');
        }
        $advertisement->save();
        return redirect()->route('settings.advertisements.index')->with(['message' => __('lang.successfully_updated')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $advertisement = Advertisement::find($id);
        $advertisement->delete();
        return redirect()->route('settings.advertisements.index')->with(['message' => __('lang.successfully_deleted')]);
    }
}