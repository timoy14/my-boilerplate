<?php

namespace App\Http\Controllers\Dashboard\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Model\IntroductionScreen;
use App\Model\Role;
use Illuminate\Http\Request;

class IntroductionScreenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $introductionScreens = IntroductionScreen::with('role')->get();
        return view('admin.settings.introduction-screens.index', compact('introductionScreens'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = role::all();
        return view('admin.settings.introduction-screens.create', compact('roles'));
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

            'role_id' => 'required|numeric',
        ]);
        $IntroductionScreen = new IntroductionScreen();

        $IntroductionScreen->ar = $request->ar;
        $IntroductionScreen->en = $request->en;
        $IntroductionScreen->display = $request->display;

        $IntroductionScreen->role_id = $request->role_id;
        if (!empty($request->image)) {
            $filename = md5(uniqid()) . date('dmY') . '.' . $request->image->getClientOriginalExtension();
            $IntroductionScreen->image = $request->image->storeAs('', $filename, 'public');
        }
        $IntroductionScreen->save();
        return redirect()->route('settings.introduction-screens.index')->with(['message' => __('lang.successfully_added')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $IntroductionScreen = IntroductionScreen::find($id);
        $IntroductionScreen->display = !$IntroductionScreen->display;
        $IntroductionScreen->save();
        return redirect()->route('settings.introduction-screens.index')->with(['message' => __('lang.successfully_updated')]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $introductionScreen = IntroductionScreen::find($id);
        $roles = role::all();
        return view('admin.settings.introduction-screens.edit', compact('introductionScreen', 'roles'));
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

            'role_id' => 'required|numeric',
        ]);
        $IntroductionScreen = IntroductionScreen::find($id);

        $IntroductionScreen->ar = $request->ar;
        $IntroductionScreen->en = $request->en;
        $IntroductionScreen->display = $request->display;
        $IntroductionScreen->role_id = $request->role_id;
        if (!empty($request->image)) {
            $filename = md5(uniqid()) . date('dmY') . '.' . $request->image->getClientOriginalExtension();
            $IntroductionScreen->image = $request->image->storeAs('', $filename, 'public');
        }
        $IntroductionScreen->save();
        return redirect()->route('settings.introduction-screens.index')->with(['message' => __('lang.successfully_updated')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $IntroductionScreen = IntroductionScreen::find($id);
        $IntroductionScreen->delete();
        return redirect()->route('settings.introduction-screens.index')->with(['message' => __('lang.successfully_deleted')]);
    }
}