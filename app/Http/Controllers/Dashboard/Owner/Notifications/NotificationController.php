<?php

namespace App\Http\Controllers\Dashboard\Owner\Notifications;

use App\Http\Controllers\Controller;
use App\Model\Branch;
use App\Model\Notification;
use App\User;
use Auth;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->isOwner()) {

            $branches = Branch::withTrashed()->where('user_id', Auth::user()->id)->pluck('id')->toArray();
            $notifications = Notification::where('user_id', Auth::user()->id)->orWhereIn('branch_id', $branches)->get();
            return view('owner.notifications.index', compact('notifications'));
        } elseif (Auth::user()->isBranchManager()) {
            $notifications = Notification::where('user_id', Auth::user()->id)->orWhere('branch_id', Auth::user()->branch_id)->get();
            return view('owner.notifications.index', compact('notifications'));
        } else {
            $notifications = Notification::where('user_id', Auth::user()->id)->get();
            return view('owner.notifications.index', compact('notifications'));
        }

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
        //
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
        //
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