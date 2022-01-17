<?php

namespace App\Http\Controllers;

use App;
use Auth;
use App\User;
use App\Model\Purchase;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::user()->isAdmin() || Auth::user()->isAdminStaff()) {

            // die("TESTTTTTTTT");

            // $orders = array();
            // $clients = array();
        
            // $months = ["january","february","march","april","may","june","july","august","september","october","november","december"];
            // $year =  date("Y");

            // foreach($months as $key => $month){
            //     $key = $key+1;
            //     $from = $year."-".($key)."-1 00:00:00";
            //     if ($key%2 == 1) {
            //         $to = $year."-".($key+1)."-30 00:00:00";
            //     }elseif($key%2 == 0) {
            //         $to = $year."-".($key+1)."-31 00:00:00";
            //     }

            //     // $orders[$month] = Purchase::whereBetween('created_at', [$from, $to])->get()->count();
            //     $clients[$month] = User::where("role_id",5)->whereBetween('created_at', [$from, $to])->get()->count();
            //     $pharmacy[$month] = User::where("role_id",3)->whereBetween('created_at', [$from, $to])->get()->count();

            //     $clients[$month] = User::where("role_id",5)->whereBetween('created_at', [$from, $to])->get()->count();
            //     $cancelled[$month] = Purchase::where('status', "cancelled")->whereBetween('created_at', [$from, $to])->get()->count();
            //     $completed[$month] = Purchase::where('status', "order_complete")->whereBetween('created_at', [$from, $to])->get()->count();
            // }

            // $total_customer_count = User::where("role_id",5)->get()->count();
            // $total_cancelled_count = Purchase::where('status', "cancelled")->get()->count();
            // $total_order_count = Purchase::get()->count();
            

            return view('home');

        }
        if (Auth::user()->isBranchManager()) {
            return redirect()->route('check.information.index');
        }
        if (Auth::user()->isOwner()) {

            if (Auth::user()->isSubscribe() == null) {
                return redirect()->route('owner-subscriptions.subscriptions.subscriptions');
            } else {
                if (!Auth::user()->is_verified) {
                    return redirect()->route('owner-verify.verify.index');
                } else {
                    return view('owner');
                }
            }
        }
        if (Auth::user()->isEmployee()) {

        }
    }

    public function language($locale)
    {
        App::setLocale($locale);
        session()->put('locale', $locale);
        return redirect()->back();
    }

}