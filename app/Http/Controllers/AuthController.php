<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate(['email' => 'email|required', 'password' => 'required']);
        $credentials = $request->only('email', 'password');


        if (Auth::attempt($credentials)) {
            return response()->json(['success' => 'true', 'user' => Auth::user()]);
        }
    }
}
