<?php

namespace App\Http\Controllers\Dashboard\Admin\Subscriptions;

use App\Http\Controllers\Controller;
use App\Model\Subscription;
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
        $subscriptions = Subscription::all();
        return view('admin.subscriptions.subscriptions.index', compact('subscriptions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.subscriptions.subscriptions.create');
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
            'description' => 'required',
            'duration' => ['required', 'numeric', 'min:1', 'max:12'],
            'price' => ['required', 'numeric'],

            'multiple_branch' => ['numeric'],
            'branch_count' => 'required_if:unli,1',
            'advertisement' => ['numeric'],
            'advertisement_limit' => 'required_if:advertisement,1',
            'offer' => ['numeric'],
            'offer_limit' => 'required_if:offer,1',
            'employee' => ['numeric'],
            'branch_employee_limit' => 'required_if:employee,1',

        ]);

        $subscription = new Subscription();
        $subscription->name = $request->name;
        $subscription->name_ar = $request->name_ar;
        $subscription->description = $request->description;
        $subscription->duration = $request->duration;
        $subscription->price = $request->price;

        $subscription->multiple_branch = (($request->multiple_branch) ? $request->multiple_branch : 0);

        if (isset($request->branch_count)) {
            $subscription->branch_count = $request->branch_count;
        }
        $subscription->advertisement = (($request->advertisement) ? $request->advertisement : 0);

        if (isset($request->advertisement_limit)) {
            $subscription->advertisement_limit = $request->advertisement_limit;
        }

        $subscription->offer = (($request->offer) ? $request->offer : 0);

        if (isset($request->offer_limit)) {
            $subscription->offer_limit = $request->offer_limit;
        }
        $subscription->employee = (($request->employee) ? $request->employee : 0);
        if (isset($request->branch_employee_limit)) {
            $subscription->branch_employee_limit = $request->branch_employee_limit;
        }
        $subscription->display = (($request->display) ? $request->display : 0);
        $subscription->save();

        return redirect()->route('subscriptions.subscriptions.index')->with(['message' => __('lang.successfully_added')]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $subscription = Subscription::find($id);
        return view('admin.subscriptions.subscriptions.show', compact('subscription'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subscription = Subscription::find($id);
        return view('admin.subscriptions.subscriptions.edit', compact('subscription'));
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
            'name_ar' => 'required',
            'description' => 'required',
            'duration' => ['required', 'numeric', 'min:1', 'max:12'],
            'price' => ['required', 'numeric'],

            'multiple_branch' => ['numeric'],
            'branch_count' => 'required_if:unli,1',
            'advertisement' => ['numeric'],
            'advertisement_limit' => 'required_if:advertisement,1',
            'offer' => ['numeric'],
            'offer_limit' => 'required_if:offer,1',
            'employee' => ['numeric'],
            'branch_employee_limit' => 'required_if:employee,1',
        ]);

        $subscription = Subscription::find($id);
        $subscription->name = $request->name;
        $subscription->name_ar = $request->name_ar;
        $subscription->description = $request->description;
        $subscription->duration = $request->duration;
        $subscription->price = $request->price;

        $subscription->multiple_branch = (($request->multiple_branch) ? $request->multiple_branch : 0);

        if (isset($request->branch_count)) {
            $subscription->branch_count = $request->branch_count;
        }
        $subscription->advertisement = (($request->advertisement) ? $request->advertisement : 0);

        if (isset($request->advertisement_limit)) {
            $subscription->advertisement_limit = $request->advertisement_limit;
        }

        $subscription->offer = (($request->offer) ? $request->offer : 0);

        if (isset($request->offer_limit)) {
            $subscription->offer_limit = $request->offer_limit;
        }
        $subscription->employee = (($request->employee) ? $request->employee : 0);
        if (isset($request->branch_employee_limit)) {
            $subscription->branch_employee_limit = $request->branch_employee_limit;
        }
        $subscription->display = (($request->display) ? $request->display : 0);
        $subscription->save();

        return redirect()->route('subscriptions.subscriptions.index')->with(['message' => __('lang.successfully_updated')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subscription = Subscription::find($id);
        $subscription->delete();
        return redirect()->route('subscriptions.subscriptions.index')->with(['message' => __('lang.successfully_deleted')]);
    }
}