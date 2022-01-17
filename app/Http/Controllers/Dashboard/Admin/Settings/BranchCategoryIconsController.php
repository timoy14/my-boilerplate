<?php

namespace App\Http\Controllers\Dashboard\Admin\Settings;

use App\Http\Controllers\Controller;
use App\Model\BranchCategoryIcon;
use Illuminate\Http\Request;

class BranchCategoryIconsController extends Controller
{
    public function index()
    {
        $icons = BranchCategoryIcon::orderBy('id', 'desc')->paginate(10);

        return view('admin.settings.icons.index', compact('icons'));
    }
    public function destroy($id)
    {
        $icon = BranchCategoryIcon::find($id);
        $icon->delete();

        return redirect()->route('settings.icons.index')->with(['title' => __('lang.deleted'), 'status' => __('lang.successfully_deleted'), 'mode' => 'success']);
    }
    public function store(Request $request)
    {

        $logo = new BranchCategoryIcon();
        if (!empty($request->icon)) {
            $filename = 'item-file-' . md5(uniqid()) . date('dmY') . '.' . $request->icon->getClientOriginalExtension();
            $logo->icon = $request->icon->storeAs('', $filename, 'public');
            $logo->save();

        }
        return redirect()->route('settings.icons.index');

    }
}