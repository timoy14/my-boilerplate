<?php

namespace App\Http\Controllers\Dashboard\Owner\Settings;

use App\Http\Controllers\Controller;
use App\Model\Branch;
use App\Model\BranchCategoryIcon;
use App\Model\BranchServiceCategory;
use Auth;
use Illuminate\Http\Request;

class BranchServiceCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (Auth::user()->isOwner()) {
            $branches_count = Branch::withTrashed()->where('user_id', Auth::user()->id)->count();
            if ($branches_count == 0) {
                $subcategories = Subcategory::where('category_id', Auth::user()->category_id)->get();
                $managers = User::where('parent_id', Auth::user()->category_id)->get();
                return view('owner.branches.create', compact('subcategories', 'managers'));
            }
            $branches_ids = Branch::withTrashed()->where('user_id', Auth::user()->id)->pluck('id')->toArray();
            $branch_service_categories = BranchServiceCategory::whereIn('branch_id', $branches_ids)->get();
            return view('owner.settings.branch_service_categories.index', compact('branch_service_categories'));
        } elseif (Auth::user()->isBranchManager()) {
            $branch_service_categories = BranchServiceCategory::where('branch_manager_id', Auth::user()->id)->get();

            return view('owner.settings.branch_service_categories.index', compact('branch_service_categories'));
        }
        return back();

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $branches = Branch::where('user_id', Auth::user()->id)->get();
        $icons = BranchCategoryIcon::get();
        return view('owner.settings.branch_service_categories.create', compact('branches', 'icons'));
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

            'branch_category_icon' => 'required',
            'branch_id' => 'required|numeric',
        ]);
        $branch_service_category = new BranchServiceCategory();

        $branch_service_category->ar = $request->ar;
        $branch_service_category->en = $request->en;

        $branch_service_category->branch_id = $request->branch_id;
        $branch_service_category->branch_category_icon = $request->branch_category_icon;

        $branch_service_category->save();
        return redirect()->route('owner-settings.branch_service_categories.index')->with(['message' => __('lang.successfully_added')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $branch_service_category = BranchServiceCategory::find($id);
        $branch_service_category->display = !$branch_service_category->display;
        $branch_service_category->save();
        return redirect()->route('owner-settings.branch_service_categories.index')->with(['message' => __('lang.successfully_updated')]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $branch_service_category = BranchServiceCategory::find($id);
        $branches = Branch::where('user_id', Auth::user()->id)->get();
        $icons = BranchCategoryIcon::get();
        return view('owner.settings.branch_service_categories.edit', compact('branch_service_category', 'branches', 'icons'));
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

            'branch_id' => 'required|numeric',
        ]);
        $branch_service_category = BranchServiceCategory::find($id);

        $branch_service_category->ar = $request->ar;
        $branch_service_category->en = $request->en;

        $branch_service_category->branch_id = $request->branch_id;
        $branch_service_category->branch_category_icon = $request->branch_category_icon;

        $branch_service_category->save();
        return redirect()->route('owner-settings.branch_service_categories.index')->with(['message' => __('lang.successfully_updated')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $branch_service_category = BranchServiceCategory::find($id);
        $branch_service_category->delete();
        return redirect()->route('owner-settings.branch_service_categories.index')->with(['message' => __('lang.successfully_deleted')]);
    }
}