<?php

namespace App\Http\Controllers\Dashboard\Admin\Subscriptions;

use App\Http\Controllers\Controller;
use App\Model\Subscriber;
use App\Model\Subscription;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subscribers = Subscriber::all();
        $subscriptions = Subscription::all();
        $owners = User::whereHas('role', function ($q) {
            $q->where('id', 3);
        })->get();

        return view('admin.subscriptions.subscribers.index', compact(
            'subscribers',
            'subscriptions',
            'owners'
        ));
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

        $request->validate([
            'subscription_id' => 'required',
            'user_id' => 'required',
        ]);

        $todayDate = Carbon::now();

        $subscription = Subscription::find($request->subscription_id);

        $lastUserSubscription = Subscriber::withTrashed()
            ->where('user_id', Auth::user()->id)
            ->orderBy('id', 'desc')
            ->first();
        $isExpired = ($lastUserSubscription) ? Carbon::parse($lastUserSubscription->expired_at)->isPast() : true;
        if ($lastUserSubscription) {
            $user = User::find(Auth::user()->id);
            $user->free_trial = 1;
            $user->save();

        }
        if ($isExpired) {

            $subscription = Subscription::find($id);

            $subscriber = new Subscriber();
            $subscriber->user_id = $request->user_id;
            $subscriber->subscription_id = $id;

            $subscriber->branch_count = $subscription->branch_count;
            $subscriber->advertisement = $subscription->advertisement;
            $subscriber->advertisement_limit = $subscription->advertisement_limit;
            $subscriber->offer = $subscription->offer;
            $subscriber->offer_limit = $subscription->offer_limit;
            $subscriber->employee_limit = $subscription->employee_limit;
            $subscriber->branch_employee_limit = $subscription->branch_employee_limit;
            $subscriber->duration = $subscription->duration;
            $subscriber->limit_services = $subscription->limit_services;
            $subscriber->clinic = $subscription->clinic;
            $subscriber->price = $subscription->price;
            $subscriber->expired_at = Carbon::now()->addMonths($subscription->duration);
            $subscriber->save();

        }
        if (!$isExpired) {
            $subscription = Subscription::find($id);

            $subscriber = new Subscriber();
            $subscriber->user_id = $request->user_id;
            $subscriber->subscription_id = $id;

            $subscriber->branch_count = $subscription->branch_count;
            $subscriber->advertisement = $subscription->advertisement;
            $subscriber->advertisement_limit = $subscription->advertisement_limit;
            $subscriber->offer = $subscription->offer;
            $subscriber->offer_limit = $subscription->offer_limit;
            $subscriber->employee_limit = $subscription->employee_limit;
            $subscriber->branch_employee_limit = $subscription->branch_employee_limit;
            $subscriber->duration = $subscription->duration;
            $subscriber->limit_services = $subscription->limit_services;
            $subscriber->clinic = $subscription->clinic;
            $subscriber->price = $subscription->price;
            $subscriber->expired_at = Carbon::parse($lastUserSubscription->expired_at)->addMonths($subscription->duration);
            $subscriber->save();
        }

        // delete the last subscription
        if ($lastUserSubscription) {
            $lastUserSubscription->delete();
        }

        return redirect()->route('subscriptions.subscribers.index')->with(['message' => __('lang.successfully_added')]);

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