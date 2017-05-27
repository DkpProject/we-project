<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class AuthController extends Controller
{
    function login(Request $request) {
//        dd($request->query('email'), $request->only('email', 'password'));
        $auth = false;
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->has('remember'))) {
            $auth = true; // Success
            $request->session()->regenerate();
        }
//        dd(Auth::guard()->user());
        return response()->json([
            'auth' => $auth,
            'user' => Auth::guard()->user(),
            'intended' => URL::previous()
        ]);
    }

    function user() {
        dd(Auth::guard()->user());
    }
}
