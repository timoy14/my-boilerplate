<?php

namespace App\Http\Controllers\Dashboard\Owner\Bookings;

use App\Http\Controllers\Controller;
use App\Model\Booking;
use App\Model\BookingAppointment;
use App\Model\Branch;
use App\Model\Unavailability;
use App\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $today = Carbon::now();
        if ($request->year_month) {
            $data = $request->year_month;
            $year_month = Carbon::create(Carbon::parse($data)->format('Y'), Carbon::parse($data)->format('m'));
        } else {
            $year_month = Carbon::create($today->year, $today->month);
        }
        $selected_branch = "all";
        if ($request->branch) {
            $selected_branch = $request->branch;
            $exists = Branch::withTrashed()->where('id', $selected_branch)->orWhere('user_id', Auth::user()->id)->orWhere('branch_manager_id', Auth::user()->id)->exists();
            if (!$exists) {
                return back();
            }
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
        $bookings = null;
        $employees = [];
        $unavailabilities = [];
        if (Auth::user()->isOwner()) {

            $branches_count = Branch::withTrashed()->where('user_id', Auth::user()->id)->count();
            if ($branches_count != 0) {

                if ($selected_branch != 'all') {
                    $bookings = Booking::where('branch_id', $selected_branch)
                        ->whereYear('date', '=', Carbon::parse($year_month)->format('Y'))
                        ->whereMonth('date', '=', Carbon::parse($year_month)->format('m'))
                        ->orderBy('date', 'desc')->get();

                    $unavailabilities = Unavailability::where('branch_id', $selected_branch)
                        ->whereYear('to', '=', Carbon::parse($year_month)->format('Y'))
                        ->whereMonth('to', '=', Carbon::parse($year_month)->format('m'))
                        ->orderBy('to', 'desc')->get();

                    $employees = User::where('branch_id', $selected_branch)->get();
                } else {

                    $branches = Branch::withTrashed()->where('user_id', Auth::user()->id)->pluck('id')->toArray();
                    $employees = User::whereIn('branch_id', $branches)->get();
                    $bookings = Booking::whereIn('branch_id', $branches)
                        ->whereYear('date', '=', Carbon::parse($year_month)->format('Y'))
                        ->whereMonth('date', '=', Carbon::parse($year_month)->format('m'))
                        ->orderBy('date', 'desc')->get();

                    $unavailabilities = Unavailability::whereIn('branch_id', $branches)
                        ->whereYear('to', '=', Carbon::parse($year_month)->format('Y'))
                        ->whereMonth('to', '=', Carbon::parse($year_month)->format('m'))
                        ->orderBy('to', 'desc')->get();

                }
                $branches = Branch::withTrashed()->where('user_id', Auth::user()->id)->get();

                return view('owner.bookings.index', compact('employees', 'branches', 'selected_branch', 'unavailabilities', 'bookings', 'week_ar', 'today', 'days', 'add_space', 'week', 'add_space_end', 'year_month'));
            }

        } elseif (Auth::user()->isBranchManager()) {

            $branches = Branch::withTrashed()->where('branch_manager_id', Auth::user()->id)->pluck('id')->toArray();
            $bookings = Booking::whereIn('branch_id', $branches)
                ->whereYear('date', '=', Carbon::parse($year_month)->format('Y'))
                ->whereMonth('date', '=', Carbon::parse($year_month)->format('m'))
                ->orderBy('date', 'desc')->get();
            $unavailabilities = Unavailability::whereIn('branch_id', $branches)
                ->whereYear('to', '=', Carbon::parse($year_month)->format('Y'))
                ->whereMonth('to', '=', Carbon::parse($year_month)->format('m'))
                ->orderBy('to', 'desc')->get();

            $employees = User::whereIn('branch_id', $branches)->get();

            return view('owner.bookings.index', compact('employees', 'branches', 'selected_branch', 'unavailabilities', 'bookings', 'week_ar', 'today', 'days', 'add_space', 'week', 'add_space_end', 'year_month'));
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
        //
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
        return redirect()->route('owner-bookings.bookings.index')->with(['message' => __('lang.unavailability_added')]);
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
        return redirect()->route('owner-bookings.bookings.index')->with(['message' => __('lang.unavailability_updated')]);
    }

    public function destroy_unavailablity(Request $request)
    {
        $unavailability = Unavailability::find($request->id);
        $unavailability->delete();
        return redirect()->route('owner-bookings.bookings.index')->with(['message' => __('lang.unavailability_updated')]);
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
            'booking_status' => 'required',
            'booking_date' => 'required',
            'booking_time_in' => 'required',
        ]);
        $booking = Booking::find($id);
        if ($booking->employee_id != null) {
            $request->validate([
                'employee_id' => 'required',
            ]);
        }

        $booking->status = $request->booking_status;

        if ($booking->employee_id != null) {
            $booking->employee_id = $request->employee_id;
        }

        $booking->date = Carbon::create($request->booking_date)->format('Y-m-d');
        $booking->save();
        $appointment = BookingAppointment::find($booking->booking_appointment->id);
        $appointment->date = Carbon::create($request->booking_date)->format('Y-m-d');
        if ($booking->employee_id != null) {
            $booking->employee_id = $request->employee_id;
        }

        $appointment->save();

        return redirect()->route('owner-bookings.bookings.index', 'year_month=' . $request->year_month)->with(['message' => __('lang.booking_updated')]);

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