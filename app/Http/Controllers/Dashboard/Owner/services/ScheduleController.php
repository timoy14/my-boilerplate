<?php

namespace App\Http\Controllers\Dashboard\Owner\Services;

use App\Http\Controllers\Controller;
use App\Model\Appointment;
use App\Model\Branch;
use App\Model\Subcategory;
use App\User;
use Auth;

class ScheduleController extends Controller
{
    public function index()
    {
        $branches_count = Branch::withTrashed()->where('user_id', Auth::user()->id)->count();
        if (Auth::user()->isOwner()) {

            if ($branches_count == 0) {
                $subcategories = Subcategory::where('category_id', Auth::user()->category_id)->get();
                $managers = User::where('parent_id', Auth::user()->category_id)->get();
                return view('owner.branches.create', compact('subcategories', 'managers'));
            }

            $branches = Branch::withTrashed()->where('user_id', Auth::user()->id)->pluck('id')->toArray();
            $appointments = Appointment::withTrashed()->whereIn('branch_id', $branches)->get();
            $branches = Branch::withTrashed()->where('user_id', Auth::user()->id)->get();
            return view('owner.services.index', compact('services', 'branches', 'branches_count'));

        } elseif (Auth::user()->isBranchManager()) {

            $services = Service::withTrashed()->where('branch_manager_id', Auth::user()->id)->get();
            $branches = Branch::withTrashed()->where('branch_manager_id', Auth::user()->id)->get();
            return view('owner.services.index', compact('services', 'branches', 'branches_count'));
        }
        return back();
    }

}