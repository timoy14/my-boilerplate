<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
     */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');

    }

    public function login(Request $request)
    {

        if(isset($request->phone)){
            $this->validate($request, [
                'phone' => 'required',
                'password' => 'required|min:6',
            ]);

            $user = $request->only('phone', 'password');

            if (preg_match('/^\d{10}$/', $request->phone)) {

                if (Auth::attempt($user)) {

                    if (!Auth::user()->is_verified) {

                        return redirect()->route('owner-verify.verify.index');

                    } else {
                        $role = Auth()->user()->role->en;
            
                        if ((strpos(Auth()->user()->role->en, 'Admin') !== false)) {
                            return redirect('/');

                        } else {
                            Auth::logout();
                            return redirect('login')->withErrors(['phone' => __('lang.no_access') . " " . $role]);
                        }
                    }
                }

                return redirect('login')->withErrors(['phone' => __('lang.noaccount')]);
            }
            
            return redirect('login')->withErrors(['phone' => __('lang.must_ten_digit')]);
        }

        if(isset($request->email)){
            $this->validate($request, [
                'email' => 'required',
                'password' => 'required|min:6',
            ]);

            $user = $request->only('email', 'password');

            

            if (Auth::attempt($user)) {

                if (!Auth::user()->is_verified) {

                    return redirect()->route('owner-verify.verify.index');

                } else {
                    $role = Auth()->user()->role->en;
        
                    if ((strpos(Auth()->user()->role->en, 'Admin') !== false)) {
                        return redirect('/');

                    } else {
                        Auth::logout();
                        return redirect('login')->withErrors(['email' => __('lang.no_access') . " " . $role]);
                    }
                }
            }

            return redirect('login')->withErrors(['phone' => __('lang.noaccount')]);
           
        }
    }
}