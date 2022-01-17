<?php

namespace App\Http\Controllers\Dashboard\Owner\Settings;

use App\Http\Controllers\Controller;
use App\Model\Appointment;
use App\Model\Branch;
use App\Model\Subcategory;
use App\Model\WeekAvailability;
use App\User;
use Auth;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $details = "";
        if ($request->details) {
            $details = $request->details;
            $exists = Branch::withTrashed()->where('id', $details)->orWhere('user_id', Auth::user()->id)->orWhere('branch_manager_id', Auth::user()->id)->exists();
            if (!$exists) {
                return back();
            }
        }
        $times = [
            '0000',
            '0030',
            '0100',
            '0130',
            '0200',
            '0230',
            '0300',
            '0330',
            '0400',
            '0430',
            '0500',
            '0530',
            '0600',
            '0630',
            '0700',
            '0730',
            '0800',
            '0830',
            '0900',
            '0930',
            '1000',
            '1030',
            '1100',
            '1130',
            '1200',
            '1230',
            '1300',
            '1330',
            '1400',
            '1430',
            '1500',
            '1530',
            '1600',
            '1630',
            '1700',
            '1730',
            '1800',
            '1830',
            '1900',
            '1930',
            '2000',
            '2030',
            '2100',
            '2130',
            '2200',
            '2230',
            '2300',
            '2330',
        ];
        if (Auth::user()->isOwner()) {
            $branches_count = Branch::withTrashed()->where('user_id', Auth::user()->id)->count();
            if ($branches_count == 0) {
                $subcategories = Subcategory::where('category_id', Auth::user()->category_id)->get();
                $managers = User::where('parent_id', Auth::user()->category_id)->get();
                return view('owner.branches.create', compact('subcategories', 'managers'));
            }
            if ($request->details) {
                $branches_ids = Branch::withTrashed()->where('id', '<>', $details)->where('user_id', Auth::user()->id)->pluck('id')->toArray();
                array_unshift($branches_ids, $details);
            } else {
                $branches_ids = Branch::withTrashed()->where('user_id', Auth::user()->id)->pluck('id')->toArray();
            }

            foreach ($branches_ids as $branch) {
                $week_availability = WeekAvailability::firstOrCreate(['branch_id' => $branch]);
                $appointment = Appointment::firstOrCreate(['branch_id' => $branch], );
            }
            $branches = Branch::withTrashed()->whereIn('id', $branches_ids)->get();

            return view('owner.settings.schedules.index', compact('branches', 'times', 'details'));

        } elseif (Auth::user()->isBranchManager()) {
            $branches = Branch::withTrashed()->where('branch_manager_id', Auth::user()->id)->first();
            $week_availability = WeekAvailability::firstOrCreate(['branch_id' => $branches->id]);
            $appointment = Appointment::firstOrCreate(['branch_id' => $branches->id]);
            $week_availabilities = WeekAvailability::whereIn('branch_id', [$branches->id])->orderBy('id', 'desc')->get();
            return view('owner.settings.schedules.index', compact('branches', 'times'));
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
        return view('owner.settings.branch_service_categories.create', compact('branches'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }
    public function store_unavailablity(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

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
        return view('owner.settings.branch_service_categories.edit', compact('branch_service_category', 'branches'));
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

        ]);
        $branch = Branch::find($id);

        $week_availability = WeekAvailability::find($branch->week_availability->id);

        $week_availability->time_in = $request->time_in;
        $week_availability->time_out = $request->time_out;
        if ($week_availability->sunday != $request->sunday) {
            $week_availability->sunday = !$week_availability->sunday;
        }
        if ($week_availability->monday != $request->monday) {
            $week_availability->monday = !$week_availability->monday;
        }
        if ($week_availability->tuesday != $request->tuesday) {
            $week_availability->tuesday = !$week_availability->tuesday;
        }
        if ($week_availability->wednesday != $request->wednesday) {
            $week_availability->wednesday = !$week_availability->wednesday;
        }
        if ($week_availability->thursday != $request->thursday) {
            $week_availability->thursday = !$week_availability->thursday;
        }
        if ($week_availability->friday != $request->friday) {
            $week_availability->friday = !$week_availability->friday;
        }
        if ($week_availability->saturday != $request->saturday) {
            $week_availability->saturday = !$week_availability->saturday;
        }
        $week_availability->save();
        $times = [
            '0000',
            '0030',
            '0100',
            '0130',
            '0200',
            '0230',
            '0300',
            '0330',
            '0400',
            '0430',
            '0500',
            '0530',
            '0600',
            '0630',
            '0700',
            '0730',
            '0800',
            '0830',
            '0900',
            '0930',
            '1000',
            '1030',
            '1100',
            '1130',
            '1200',
            '1230',
            '1300',
            '1330',
            '1400',
            '1430',
            '1500',
            '1530',
            '1600',
            '1630',
            '1700',
            '1730',
            '1800',
            '1830',
            '1900',
            '1930',
            '2000',
            '2030',
            '2100',
            '2130',
            '2200',
            '2230',
            '2300',
            '2330',
        ];
        $appointment = Appointment::find($branch->appointment->id);
        foreach ($times as $time) {
            $i = 'time_' . $time;
            if ($appointment->$i != $request->$i) {
                $appointment->$i = !$appointment->$i;
            }

        }
        $appointment->save();
        return redirect()->route('owner-settings.schedules.index', 'details=' . $branch->id)->with(['message' => __('lang.successfully_updated')]);
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