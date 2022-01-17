<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;

class AdminLoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('auth.admin');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'phone' => 'required|digits:10',
            'password' => 'required|min:6',
        ]);

        $user = $request->only('phone', 'password');

        if (Auth::attempt($user)) {
            if ((strpos(Auth()->user()->role->en, 'Admin') !== false)) {
                return redirect('/');
            } elseif ((strpos(Auth()->user()->role->en, 'Admin Staff ') !== false)) {
                return redirect('/');
            } else {
                Auth::logout();
                return redirect('administrator')->withErrors(['phone' => __('lang.not_administrator_account')]);
            }
        }

        return redirect('administrator')->withErrors(['phone' => __('lang.do_not_match_records')]);
    }

}