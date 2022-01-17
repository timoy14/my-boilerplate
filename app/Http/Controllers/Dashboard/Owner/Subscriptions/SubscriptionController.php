<?php

namespace App\Http\Controllers\Dashboard\Owner\Subscriptions;

use App\Http\Controllers\Controller;
use App\Model\Subscriber;
use App\Model\Subscription;
use App\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $subscribers = Subscriber::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->get();

        return view('owner.subscriptions.index', compact('subscribers'));
    }
    public function subscription()
    {

        $subscriptions = Subscription::where('display', 1)->get();
        return view('owner.subscriptions.subscription', compact('subscriptions'));

    }
    public function subscribe($id)
    {

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
            $subscriber->user_id = Auth::user()->id;
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
            $subscriber->user_id = Auth::user()->id;
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

        return redirect()->route('home')->with(['message' => __('lang.successfully_subscribed')]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $subscription = Subscriber::find($id);

        if ($subscription->user_id == Auth::user()->id) {
            return view('owner.subscriptions.show', compact('subscription'));
        }
        return back();

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Subscriber::find($id);
        $cities = City::all();
        $genders = Gender::all();
        return view('admin.users.subscription.edit', compact('user', 'genders', 'cities'));
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
            'name' => 'required',
            'phone' => ['required', 'numeric', 'min:10'],
            'password' => ['confirmed'],
        ]);

        $user = Subscriptions::find($id);
        $user->city_id = $request->city;
        $user->gender_id = $request->gender;
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->bank_name = $request->bank_name;
        $user->bank_account_num = $request->bank_account_num;

        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        if (!empty($request->file)) {
            $filename = md5(uniqid()) . date('dmY') . '.' . $request->file->getClientOriginalExtension();
            $user->avatar = $request->file->storeAs('', $filename, 'public');
        }

        $user->save();

        return redirect()->route('users.subscription.index')->with(['message' => __('lang.successfully_updated')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Subscriptions::find($id);
        $user->delete();
        return redirect()->route('users.subscription.index')->with(['message' => __('lang.successfully_deleted')]);
    }
}