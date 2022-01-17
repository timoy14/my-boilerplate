<?php

namespace App\Http\Controllers\Dashboard\Admin\Notifications;

use App\Events\AdminPushNotifEvent;
use App\Http\Controllers\Controller;
use App\Model\Notification;
use App\Model\Role;
use App\User;
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

        $notifications = Notification::orderBy('id', 'DESC')->paginate(15);
        $roles = Role::get();
        return view('admin.notifications.index', compact('notifications','roles'));

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

        $users = User::where("role_id",$request->role)->get();

        foreach ($users as $user) {
            $notification = new Notification;
            $notification->user_id = $user->id;
            $notification->title = $request->title;
            $notification->slug = "admin";
            $notification->message = $request->message;

            $eventVar = [
                "title_en" =>  $request->title,
                "title_ar" =>  $request->title,
                "message_en" => $request->message,
                "message_ar" => $request->message,
                "user_id_notify" => $user->id
            ];
            
            event(new AdminPushNotifEvent($eventVar));
            $notification->save();
        }

        

        return redirect()->route('admin.notifications.index')->with(['message' => __('lang.sent_successfully')]);
        
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