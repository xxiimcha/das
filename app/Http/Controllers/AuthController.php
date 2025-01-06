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
        // Validate the incoming request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        // Retrieve only email and password from the request
        $credentials = $request->only('email', 'password');

        // Attempt to log the user in
        if (Auth::attempt($credentials)) {
            $role = Auth::user()->role;

            // Redirect based on user role
            switch ($role) {
                case 'admin':
                    return redirect()->route('dashboard')->with([
                        'success' => 'Welcome to the Admin Dashboard!',
                    ]);

                case 'committee':
                    return redirect()->route('committee.dashboard')->with([
                        'success' => 'Welcome to the Committee Dashboard!',
                    ]);


                default:
                    // If role is undefined or not handled, redirect to a default page
                    Auth::logout();
                    return redirect()->route('login')->with('error', 'Unauthorized role. Please contact the administrator.');
            }
        }

        // If authentication fails
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
