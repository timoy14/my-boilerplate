<?php

namespace App\Http\Controllers\Dashboard\Owner\Users;

use App\Http\Controllers\Controller;
use App\Model\Booking;
use App\Model\Branch;
use App\Model\City;
use App\Model\Gender;
use App\Model\Unavailability;
use App\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BranchmanagerController extends Controller
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
                $subcategories = Subcategory::where('category_id', Auth::user()->category_id)->get();
                $managers = User::where('parent_id', Auth::user()->category_id)->get();
                return view('owner.branches.create', compact('subcategories', 'managers'));
            }

            $managers = User::where('parent_id', Auth::user()->id)->whereHas('role', function ($q) {
                $q->where('id', 4);
            })->orderBy('id', 'desc')->get();

            return view('owner.users.branch_managers.index', compact('managers'));

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

        $branches = Branch::withTrashed()
            ->where('user_id', Auth::user()->id)
            ->where('branch_manager_id', null)
            ->orderBy('id', 'desc')->get();
        $cities = City::all();
        $genders = Gender::all();
        return view('owner.users.branch_managers.create', compact('genders', 'cities', 'branches'));
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
            'city' => ['required', 'numeric'],
            'gender' => ['required', 'numeric'],
            'branch_id' => ['numeric'],
            'name' => 'required',
            'phone' => ['required', 'numeric', 'unique:users', 'min:10'],
            'password' => ['required', 'confirmed', 'min:6'],
        ]);

        $user = new User();
        $user->role_id = 4;
        $user->city_id = $request->city;
        $user->gender_id = $request->gender;
        $user->parent_id = Auth::user()->id;
        $user->name = $request->name;
        $user->phone = $request->phone;

        $user->password = bcrypt($request->password);
        $user->branch_id = (($request->branch_id) ? $request->branch_id : null);

        $user->email = $request->email;
        $user->activation_code = md5(12345);
        $user->is_verified = true;

        if (!empty($request->file)) {
            $filename = md5(uniqid()) . date('dmY') . '.' . $request->file->getClientOriginalExtension();
            $user->avatar = $request->file->storeAs('', $filename, 'public');
        }

        $user->save();
        if ($request->branch_id) {
            $branch = Branch::find($request->branch_id);
            $branch->branch_manager_id = $user->id;
            $branch->save();
        }

        return redirect()->route('owner-users.branch_managers.index')->with(['message' => __('lang.successfully_added')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $user = User::find($id);
        if ($user->branch_id == null) {
            $branches = Branch::withTrashed()
                ->where('user_id', Auth::user()->id)
                ->where('branch_manager_id', null)
                ->orderBy('id', 'desc')->get();
        } else {
            $branches = Branch::withTrashed()
                ->where('user_id', Auth::user()->id)
                ->orWhere('branch_manager_id', $user->branch_id)
                ->where('branch_manager_id', null)
                ->orderBy('id', 'desc')->get();
        }

        $cities = City::all();
        $genders = Gender::all();

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

        $bookings = Booking::where('employee_id', $id)
            ->whereYear('date', '=', Carbon::parse($year_month)->format('Y'))
            ->whereMonth('date', '=', Carbon::parse($year_month)->format('m'))
            ->orderBy('date', 'desc')->get();

        $unavailabilities = Unavailability::where('user_id', $id)
            ->whereYear('to', '=', Carbon::parse($year_month)->format('Y'))
            ->whereMonth('to', '=', Carbon::parse($year_month)->format('m'))
            ->orderBy('to', 'desc')->get();

        return view('owner.users.branch_managers.show', compact('unavailabilities', 'bookings', 'week_ar', 'today', 'days', 'add_space', 'week', 'add_space_end', 'year_month', 'branches', 'user', 'genders', 'cities'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        if ($user->branch_id == null) {
            $branches = Branch::withTrashed()
                ->where('user_id', Auth::user()->id)
                ->where('branch_manager_id', null)
                ->orderBy('id', 'desc')->get();
        } else {
            $branches = Branch::withTrashed()
                ->where('user_id', Auth::user()->id)
                ->orWhere('branch_manager_id', $user->branch_id)
                ->where('branch_manager_id', null)
                ->orderBy('id', 'desc')->get();
        }

        $cities = City::all();
        $genders = Gender::all();
        return view('owner.users.branch_managers.edit', compact('branches', 'user', 'genders', 'cities'));
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
            'city' => ['required', 'numeric'],
            'gender' => ['required', 'numeric'],
            'branch_id' => ['numeric'],
            'name' => 'required',
            'phone' => ['required', 'numeric', 'min:10'],
            'password' => ['confirmed'],
        ]);

        $user = User::find($id);
        $user->role_id = 4;
        $user->city_id = $request->city;
        $user->gender_id = $request->gender;
        $user->parent_id = Auth::user()->id;
        $user->name = $request->name;
        $user->phone = $request->phone;

        $user->password = bcrypt($request->password);
        $user->branch_id = (($request->branch_id) ? $request->branch_id : null);

        $user->email = $request->email;
        $user->activation_code = md5(12345);
        $user->is_verified = true;

        if (!empty($request->file)) {
            $filename = md5(uniqid()) . date('dmY') . '.' . $request->file->getClientOriginalExtension();
            $user->avatar = $request->file->storeAs('', $filename, 'public');
        }

        $user->save();
        if ($request->branch_id) {
            $branch = Branch::find($request->branch_id);
            $branch->branch_manager_id = $user->id;
            $branch->save();
        }

        return redirect()->route('owner-users.branch_managers.index')->with(['message' => __('lang.successfully_updated')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        if ($user->branch_id != null) {
            $branch = Branch::find($request->branch_id);
            $branch->branch_manager_id = null;
            $branch->save();
        }
        return redirect()->route('owner-users.branch_managers.index')->with(['message' => __('lang.successfully_deleted')]);
    }
}