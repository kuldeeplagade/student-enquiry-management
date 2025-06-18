<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login'); 
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();
            if ($user->role === 'superadmin') {
                return redirect()->route('revenue.summary');
            } else {
                return redirect()->route('enquiries.index');
            }
        }

        return back()->with('error', 'Invalid email or password.');
    }
}
