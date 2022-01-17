<?php

namespace App\Http\Controllers\Dashboard\Owner\Services;

use App\Http\Controllers\Controller;
use App\Model\Booking;
use App\Model\Branch;
use App\Model\BranchServiceCategory;
use App\Model\Image;
use App\Model\Service;
use App\Model\Subcategory;
use App\Model\Unavailability;
use App\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $branches_count = Branch::withTrashed()->where('user_id', Auth::user()->id)->count();
        if (Auth::user()->isOwner()) {

            if ($branches_count == 0) {
                $subcategories = Subcategory::where('category_id', Auth::user()->category_id)->orderBy('id', 'desc')->get();
                $managers = User::where('parent_id', Auth::user()->category_id)->orderBy('id', 'desc')->get();
                return view('owner.branches.create', compact('subcategories', 'managers'));
            }

            $branches = Branch::withTrashed()->where('user_id', Auth::user()->id)->pluck('id')->toArray();
            $services = Service::withTrashed()->whereIn('branch_id', $branches)->orderBy('id', 'desc')->get();
            $branches = Branch::withTrashed()->where('user_id', Auth::user()->id)->orderBy('id', 'desc')->get();
            return view('owner.services.index', compact('services', 'branches', 'branches_count'));

        } elseif (Auth::user()->isBranchManager()) {

            $services = Service::withTrashed()->where('branch_manager_id', Auth::user()->id)->get();
            $branches = Branch::withTrashed()->where('branch_manager_id', Auth::user()->id)->get();
            return view('owner.services.index', compact('services', 'branches', 'branches_count'));
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

        if (Auth::user()->isOwner()) {
            $branches_count = Branch::withTrashed()->where('user_id', Auth::user()->id)->count();
            if ($branches_count == 0) {
                $subcategories = Subcategory::where('category_id', Auth::user()->category_id)->orderBy('id', 'desc')->get();
                $managers = User::where('parent_id', Auth::user()->category_id)->orderBy('id', 'desc')->get();
                return view('owner.branches.create', compact('subcategories', 'managers'));
            }

            $branches_id = Branch::withTrashed()->where('user_id', Auth::user()->id)->pluck('id')->toArray();
            $branches = Branch::withTrashed()->where('user_id', Auth::user()->id)->with('branch_service_categories')->orderBy('id', 'desc')->get();
            $branch_service_categories = BranchServiceCategory::whereIn('branch_id', $branches_id)->orderBy('id', 'desc')->get();
            $managers = User::where('parent_id', Auth::user()->category_id)->orderBy('id', 'desc')->get();
            return view('owner.services.create', compact('branch_service_categories', 'branches', 'managers'));

        } elseif (Auth::user()->isBranchManager()) {
            $branches = Branch::withTrashed()->where('branch_manager_id', Auth::user()->branch_id)->with('branch_service_categories')->get();
            $branch_service_categories = BranchServiceCategory::where('branch_id', Auth::user()->branch_id)->get();
            $managers = User::where('id', Auth::user()->id)->get();
            return view('owner.services.create', compact('branch_service_categories', 'branches', 'managers'));
        }
        return back();
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

            'en' => 'required',
            'ar' => 'required',
            'branch_id' => ['required', 'numeric'],
            'branch_service_category_id' => ['required', 'numeric'],
            'duration' => 'required',
            'price' => 'required',

        ]);

        $service = new Service();

        $service->en = $request->en;
        $service->ar = $request->ar;

        $service->branch_id = $request->branch_id;
        $service->branch_service_category_id = $request->branch_service_category_id;

        $service->duration = $request->duration;
        $service->price = $request->price;

        if (isset($request->description)) {
            $service->description = $request->description;
        }
        if (!empty($request->icon)) {
            $filename = md5(uniqid()) . date('dmY') . '.' . $request->icon->getClientOriginalExtension();
            $service->icon = $request->icon->storeAs('', $filename, 'public');
        }

        $service->save();

        // if ($request->images) {
        //     foreach ($request->images as $file) {
        //         $image = new Image();
        //         if ($file) {
        //             $filename = md5(uniqid() . date('dmYhis')) . '.' . $file->getClientOriginalExtension();
        //             $file->storeAs('', $filename, 'public');
        //             $image->branch_id = $branch->id;
        //             $image->avatar = $filename;
        //             $image->save();
        //         }
        //     }
        // }

        return redirect()->route('owner-services.services.index')->with(['message' => __('lang.successfully_added')]);
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

        $bookings = Booking::whereHas('booking_services', function ($q) use ($id) {
            $q->where('service_id', $id);
        })
            ->whereYear('date', '=', Carbon::parse($year_month)->format('Y'))
            ->whereMonth('date', '=', Carbon::parse($year_month)->format('m'))
            ->orderBy('date', 'desc')->get();

        $unavailabilities = Unavailability::where('service_id', $id)
            ->whereYear('to', '=', Carbon::parse($year_month)->format('Y'))
            ->whereMonth('to', '=', Carbon::parse($year_month)->format('m'))
            ->orderBy('to', 'desc')->get();

        $service = Service::withTrashed()->find($id);
        $branches_id = Branch::withTrashed()->where('user_id', Auth::user()->id)->pluck('id')->toArray();
        $branches = Branch::withTrashed()->where('user_id', Auth::user()->id)->with('branch_service_categories')->get();
        $branch_service_categories = BranchServiceCategory::where('branch_id', $service->branch_id)->get();
        $managers = User::where('parent_id', Auth::user()->category_id)->get();

        return view('owner.services.show', compact('id', 'unavailabilities', 'bookings', 'week_ar', 'today', 'days', 'add_space', 'week', 'add_space_end', 'year_month', 'branch_service_categories', 'branches', 'managers', 'service'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $service = Service::withTrashed()->find($id);

        if ($service->branch->user_id == Auth::user()->id || $service->branch->manager_id == Auth::user()->id) {

            $branches_id = Branch::withTrashed()->where('user_id', Auth::user()->id)->pluck('id')->toArray();
            $branches = Branch::withTrashed()->where('user_id', Auth::user()->id)->with('branch_service_categories')->get();
            $branch_service_categories = BranchServiceCategory::where('branch_id', $service->branch_id)->get();
            $managers = User::where('parent_id', Auth::user()->category_id)->get();
            return view('owner.services.edit', compact('branch_service_categories', 'branches', 'managers', 'service'));
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

        $service = Service::find($id);
        if ($service->branch->user_id == Auth::user()->id || $service->branch->manager_id == Auth::user()->id) {

            $request->validate([

                'en' => 'required',
                'ar' => 'required',
                'branch_id' => ['required', 'numeric'],
                'branch_service_category_id' => ['required', 'numeric'],
                'duration' => 'required',
                'price' => 'required',

            ]);

            $service->en = $request->en;
            $service->ar = $request->ar;

            $service->branch_id = $request->branch_id;
            $service->branch_service_category_id = $request->branch_service_category_id;

            $service->duration = $request->duration;
            $service->price = $request->price;

            if (isset($request->description)) {
                $service->description = $request->description;
            }
            if (!empty($request->icon)) {
                $filename = md5(uniqid()) . date('dmY') . '.' . $request->icon->getClientOriginalExtension();
                $service->icon = $request->icon->storeAs('', $filename, 'public');
            }

            $service->save();

            // if ($request->images) {
            //     foreach ($request->images as $file) {
            //         $image = new Image();
            //         if ($file) {
            //             $filename = md5(uniqid() . date('dmYhis')) . '.' . $file->getClientOriginalExtension();
            //             $file->storeAs('', $filename, 'public');
            //             $image->branch_id = $branch->id;
            //             $image->avatar = $filename;
            //             $image->save();
            //         }
            //     }
            // }

            return redirect()->route('owner-services.services.index')->with(['message' => __('lang.successfully_updated')]);

        }
        return back();
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
            'service_id' => 'required',
        ]);

        $unavailability = new Unavailability();
        $unavailability->service_id = $request->service_id;
        $unavailability->to = Carbon::create($request->unavail_to)->format('Y-m-d');

        $unavailability->from = Carbon::create($request->unavail_from)->format('Y-m-d');
        $unavailability->save();
        return redirect()->route('owner-services.services.show', $request->service_id)->with(['message' => __('lang.unavailability_added')]);
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
        return redirect()->route('owner-services.services.show', $unavailability->service_id)->with(['message' => __('lang.unavailability_updated')]);
    }

    public function destroy_unavailablity(Request $request)
    {
        $unavailability = Unavailability::find($request->id);
        $unavailability->delete();
        return redirect()->route('owner-services.services.show', $unavailability->service_id)->with(['message' => __('lang.unavailability_updated')]);
    }
    public function image_destroy($id)
    {
        $image = Image::find($id);
        $image->delete();
        return redirect()->route('owner-branches.branches.edit', $image->branch_id)->with(['message' => __('lang.successfully_deleted')]);
    }
}