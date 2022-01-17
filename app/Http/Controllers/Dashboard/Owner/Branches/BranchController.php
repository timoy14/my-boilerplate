<?php

namespace App\Http\Controllers\Dashboard\Owner\Branches;

use App\Http\Controllers\Controller;
use App\Model\Booking;
use App\Model\Branch;
use App\Model\Image;
use App\Model\Subcategory;
use App\Model\Unavailability;
use App\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->isOwner() && Auth::user()->category_id == 1) {
            $branches_count = Branch::withTrashed()->where('user_id', Auth::user()->id)->count();
            if ($branches_count == 0) {
                $subcategories = Subcategory::where('category_id', Auth::user()->category_id)->get();
                $managers = User::where('parent_id', Auth::user()->category_id)->get();
                return view('owner.branches.create', compact('subcategories', 'managers'));
            }
            $branches = Branch::withTrashed()->where('user_id', Auth::user()->id)->orderBy('id', 'desc')->get();
            return view('owner.branches.index', compact('branches'));
        } elseif (Auth::user()->isOwner() && Auth::user()->category_id != 1) {
            $branches_count = Branch::withTrashed()->where('user_id', Auth::user()->id)->count();
            if ($branches_count == 0) {
                $subcategories = Subcategory::where('category_id', Auth::user()->category_id)->get();
                $managers = User::where('parent_id', Auth::user()->category_id)->get();
                return view('owner.branches.create', compact('subcategories', 'managers'));
            }
            $branch = Branch::where('user_id', Auth::user()->id)->first();
            $subcategories = Subcategory::where('category_id', Auth::user()->category_id)->get();
            $managers = User::where('parent_id', Auth::user()->category_id)->get();
            return view('owner.branches.show', compact('subcategories', 'managers', 'branch'));

        } elseif (Auth::user()->isBranchManager()) {
            $branches = Branch::withTrashed()->where('branch_manager_id', Auth::user()->id)->first();
            return view('owner.branches.show', compact('branches'));
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

        $subcategories = Subcategory::where('category_id', Auth::user()->category_id)->get();
        $managers = User::where('parent_id', Auth::user()->category_id)->where('role_id', 5)->get();
        return view('owner.branches.create', compact('subcategories', 'managers'));
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

            'name' => 'required',
            'name_ar' => 'required',
            'subcategory' => ['numeric'],
            'email' => ['email', 'required'],
            'phone' => ['required', 'numeric', 'min:10'],
            'address' => 'required',
            'address_ar' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'avatar' => 'required',

        ]);

        $branch = new Branch();

        $branch->name = $request->name;
        $branch->name_ar = $request->name_ar;
        $branch->user_id = Auth::user()->id;
        if (isset($request->branch_manager)) {
            $branch->branch_manager_id = $request->branch_manager;
        }
        $branch->subcategory_id = $request->subcategory;
        $branch->phone = $request->phone;

        $branch->email = $request->email;
        $branch->phone = $request->phone;
        $branch->longitude = $request->longitude;
        $branch->latitude = $request->latitude;

        $branch->address = $request->address;

        $branch->address_ar = $request->address_ar;

        if (isset($request->whatsapp)) {
            $branch->whatsapp = $request->whatsapp;
        }
        if (isset($request->insurance)) {
            $branch->insurance = $request->insurance;
        }
        if (isset($request->payment_method)) {
            $branch->payment_method = $request->payment_method;
        }
        if (isset($request->description)) {
            $branch->description = $request->description;
        }
        if (isset($request->description_ar)) {
            $branch->description_ar = $request->description_ar;
        }
        if (!empty($request->avatar)) {
            $filename = md5(uniqid()) . date('dmY') . '.' . $request->avatar->getClientOriginalExtension();
            $branch->avatar = $request->avatar->storeAs('', $filename, 'public');
        }

        $branch->save();

        if ($request->images) {
            foreach ($request->images as $file) {
                $image = new Image();
                if ($file) {
                    $filename = md5(uniqid() . date('dmYhis')) . '.' . $file->getClientOriginalExtension();
                    $file->storeAs('', $filename, 'public');
                    $image->branch_id = $branch->id;
                    $image->avatar = $filename;
                    $image->save();
                }
            }
        }

        return redirect()->route('owner-branches.branches.index')->with(['message' => __('lang.successfully_added')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {

        $today = Carbon::now();
        if ($request->year_month) {
            $data = $request->year_month;
            $year_month = Carbon::create(Carbon::parse($data)->format('Y'), Carbon::parse($data)->format('m'));
        } else {
            $year_month = Carbon::create($today->year, $today->month);
        }
        $days = $year_month->daysInMonth;
        $firstDay = $year_month->startOfMonth()->format('l');

        $week_ar = ['الاحد', 'الاثنين', 'الثلاثاء', 'الاربعاء', 'الخميس', 'الجمعة', 'السبت'];

        $week = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        $add_space = array_search($firstDay, $week);
        $add_space_end = ($days + $add_space) % 7;
        if ($add_space_end != 0) {
            $add_space_end = 7 - $add_space_end;
        }
        $year_month = $year_month->format('F Y');

        $bookings = Booking::where('branch_id', $id)
            ->whereYear('date', '=', Carbon::parse($year_month)->format('Y'))
            ->whereMonth('date', '=', Carbon::parse($year_month)->format('m'))
            ->orderBy('date', 'desc')->get();

        $unavailabilities = Unavailability::where('branch_id', $id)
            ->whereYear('to', '=', Carbon::parse($year_month)->format('Y'))
            ->whereMonth('to', '=', Carbon::parse($year_month)->format('m'))
            ->orderBy('to', 'desc')->get();

        $branch = Branch::find($id);
        $subcategories = Subcategory::where('category_id', Auth::user()->category_id)->get();
        $managers = User::where('parent_id', Auth::user()->category_id)->get();
        return view('owner.branches.show', compact('unavailabilities', 'bookings', 'week_ar', 'today', 'days', 'add_space', 'week', 'add_space_end', 'year_month', 'subcategories', 'managers', 'branch'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $branch = Branch::find($id);
        if ($branch->user_id == Auth::user()->id || $branch->manager_id == Auth::user()->id) {
            $subcategories = Subcategory::where('category_id', Auth::user()->category_id)->get();
            $managers = User::where('parent_id', Auth::user()->category_id)->where('role_id', 5)->get();
            return view('owner.branches.edit', compact('subcategories', 'managers', 'branch'));
        }
        return back();
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

            'name' => 'required',
            'subcategory' => ['numeric'],
            'email' => ['email', 'required'],
            'phone' => ['required', 'numeric', 'min:10'],
            'address' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',

        ]);

        $branch = Branch::find($id);

        $branch->name = $request->name;
        $branch->name_ar = $request->name_ar;
        if (isset($request->branch_manager)) {
            $branch->branch_manager_id = $request->branch_manager;
        }
        $branch->subcategory_id = $request->subcategory;
        $branch->phone = $request->phone;

        $branch->email = $request->email;
        $branch->phone = $request->phone;
        $branch->longitude = $request->longitude;
        $branch->latitude = $request->latitude;
        $branch->address = $request->address;
        $branch->address_ar = $request->address_ar;
        if (isset($request->whatsapp)) {
            $branch->whatsapp = $request->whatsapp;
        }
        if (isset($request->insurance)) {
            $branch->insurance = $request->insurance;
        }
        if (isset($request->payment_method)) {
            $branch->payment_method = $request->payment_method;
        }
        if (isset($request->description_ar)) {
            $branch->description = $request->description_ar;
        }
        if (isset($request->description)) {
            $branch->description = $request->description;
        }
        if (!empty($request->avatar)) {
            $filename = md5(uniqid()) . date('dmY') . '.' . $request->avatar->getClientOriginalExtension();
            $branch->avatar = $request->avatar->storeAs('', $filename, 'public');
        }

        $branch->save();

        if ($request->images) {
            foreach ($request->images as $file) {
                $image = new Image();
                if ($file) {
                    $filename = md5(uniqid() . date('dmYhis')) . '.' . $file->getClientOriginalExtension();
                    $file->storeAs('', $filename, 'public');
                    $image->branch_id = $branch->id;
                    $image->avatar = $filename;
                    $image->save();
                }
            }
        }

        return redirect()->route('owner-branches.branches.index')->with(['message' => __('lang.successfully_updated')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {

        $branch = Branch::withTrashed()->find($id);

        $message = __('lang.enabled');

        if ($request->delete == 'enabled') {
            $branch->display = 1;
            $branch->deleted_at = null;
            $branch->save();
        } else if ($request->delete == 'disabled') {
            $message = __('lang.disabled');
            $branch->display = 0;
            $branch->save();
            $branch->delete();
        }

        return redirect()->route('owner-branches.branches.index')->with(['message' => $message]);

    }

    public function store_unavailablity(Request $request)
    {
        $request->validate([

            'unavail_to' => 'required',
            'unavail_from' => 'required',
            'branch_id' => 'required',
        ]);

        $unavailability = new Unavailability();
        $unavailability->branch_id = $request->branch_id;
        $unavailability->to = Carbon::create($request->unavail_to)->format('Y-m-d');

        $unavailability->from = Carbon::create($request->unavail_from)->format('Y-m-d');
        $unavailability->save();
        return redirect()->route('owner-branches.branches.show', $unavailability->branch_id)->with(['message' => __('lang.unavailability_added')]);
    }

    public function update_unavailablity(Request $request)
    {
        $request->validate([

            'unavail_to' => 'required',
            'unavail_from' => 'required',
            'id' => 'required',
        ]);

        $unavailability = Unavailability::find($request->id);

        $unavailability->to = Carbon::create($request->unavail_to)->format('Y-m-d');
        $unavailability->from = Carbon::create($request->unavail_from)->format('Y-m-d');
        $unavailability->save();
        return redirect()->route('owner-branches.branches.show', $unavailability->branch_id)->with(['message' => __('lang.unavailability_updated')]);
    }

    public function destroy_unavailablity(Request $request)
    {
        $unavailability = Unavailability::find($request->id);
        $unavailability->delete();
        return redirect()->route('owner-branches.branches.show', $unavailability->branch_id)->with(['message' => __('lang.unavailability_updated')]);
    }

    public function image_destroy($id)
    {
        $image = Image::find($id);
        $image->delete();
        return redirect()->route('owner-branches.branches.edit', $image->branch_id)->with(['message' => __('lang.successfully_deleted')]);
    }
}