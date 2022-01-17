<?php

namespace App\Http\Controllers\Dashboard\Owner\Verify;

use App\Events\TextMessageEvent;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Illuminate\Http\Request;

class VerifyController extends Controller
{
    public function index()
    {
        if (!Auth::user()->is_verified) {

            $user = User::find(Auth::user()->id);
            $code = rand(1000, 9999);
            session_start();
            if (!isset($_SESSION["visits"])) {
                $_SESSION["visits"] = 0;
            }

            $_SESSION["visits"] = $_SESSION["visits"] + 1;

            if ($_SESSION["visits"] > 1) {

                return view('owner.verify.verify', compact('user', ));
            } else {
                $user->activation_code = md5($code);
                $user->save();
                event(new TextMessageEvent($user->id, $code, 'REGISTER', 'seiren'));

                return view('owner.verify.verify', compact('user'));
            }

        } else {
            return redirect('/');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'otp' => ['required'],

        ]);
        if (Auth::user()->is_verified) {
            return redirect('/');
        }

        $user = User::find(Auth::user()->id);

        if (Auth::user()->activation_code === md5($request->otp)) {
            $user->save();
            $user->is_verified = true;
            $user->save();
            return redirect('/');
        }
        return back()->withErrors(['wrong otp']);

    }

    public function resend(Request $request)
    {

        // $code = 9999;
        $code = rand(1000, 9999);

        $status = 'success';

        $user = User::find(Auth::user()->id);
        $user->activation_code = md5($code);
        $user->save();
        event(new TextMessageEvent($user->id, $code, 'REGISTER'));

        return back()->with(['message' => __('lang.otp_request_sent_succesfully')]);

    }
}