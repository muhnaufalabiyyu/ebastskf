<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Mews\Captcha\Facades\Captcha;

class LoginController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            if (Auth::user()->acting == 1) {
                return redirect()->route('createbast');
            } elseif (Auth::user()->acting == 2 || Auth::user()->acting == 3) {
                return redirect()->route('approval');
            } elseif (Auth::user()->acting == 999) {
                return redirect()->route('dashboard');
            }
        } else {
            return view('login');
        }
    }

    public function reloadCaptcha()
    {
        return response()->json(['captcha' => captcha_img()]);
    }

    public function actionlogin(Request $request)
    {
        $data = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];

        if (Captcha::check($request->input('captcha'))) {
            if (Auth::attempt($data)) {
                $user = Auth::user();

                DB::table('users')
                    ->where('id', $user->id)
                    ->update(['last_access' => now(), 'is_login' => 'Y']);

                switch ($user->acting) {
                    case 1:
                        return redirect()->route('createbast');
                    case 2:
                    case 3:
                        return redirect()->route('approval');
                    case 999:
                        return redirect()->route('dashboard');
                }
            } else {
                Session::flash('error', 'Email atau Password salah.');
                return redirect('/');
            }
        } else {
            Session::flash('error', 'Captcha yang anda masukkan salah.');
            return redirect('/');
        }
    }

    public function actionlogout()
    {
        $user = Auth::user();

        DB::table('users')
            ->where('id', $user->id)
            ->update(['is_login' => 'N']);

        Auth::logout();
        return redirect()->route('login');
    }
}
