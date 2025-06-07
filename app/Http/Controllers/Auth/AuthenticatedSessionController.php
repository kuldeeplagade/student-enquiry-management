<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */

     public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (! Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
            return back()->withErrors([
                'email' => 'Invalid credentials.',
            ]);
        }

        $request->session()->regenerate();

        $user = Auth::user();

        // Redirect based on role
        if ($user->is_super_admin) {
            return redirect()->route('superadmin.dashboard');
        } else {
            return redirect()->route('admin.dashboard');
        }
    }

}
