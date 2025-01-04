<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Handle the login process.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $role = Auth::user()->role;

            if ($role === 'admin') {
                return redirect()->route('dashboard')->with([
                    'success' => 'Welcome to the Admin Dashboard!',
                    'redirect' => route('dashboard')
                ]);
            }

            return redirect()->route('home')->with([
                'success' => 'Welcome back!',
                'redirect' => route('home')
            ]);
        }

        return back()->with('error', 'Invalid credentials provided.');
    }

    /**
     * Handle the logout process.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'You have been logged out successfully.');
    }
}
