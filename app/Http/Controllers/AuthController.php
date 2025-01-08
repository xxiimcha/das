<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeEmail;

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

            switch ($role) {
                case 'admin':
                    return redirect()->route('dashboard')->with('success', 'Welcome to the Admin Dashboard!');
                case 'committee':
                    return redirect()->route('committee.dashboard')->with('success', 'Welcome to the Committee Dashboard!');
                case 'owner':
                    return redirect()->route('owner.dashboard')->with('success', 'Welcome to the Owner Dashboard!');
                case 'user': // Redirect user role to landing page
                    return redirect('/')->with('success', 'Welcome back, ' . Auth::user()->name . '!');
                default:
                    Auth::logout();
                    return redirect()->route('login')->with('error', 'Unauthorized role. Please contact the administrator.');
            }
        }

        return back()->with('error', 'Invalid credentials provided.');
    }

    /**
     * Show the registration form.
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Handle the registration.
     */
    public function register(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'mobile' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        try {
            // Create the user
            $user = User::create([
                'name' => $request->firstname . ' ' . $request->lastname,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'role' => 'user', // Set role to 'user'
                'password' => Hash::make($request->password),
            ]);

            // Send Welcome Email
            Mail::to($user->email)->send(new WelcomeEmail($user->name));

            // Redirect back to login page with success message
            return response()->json([
                'success' => true,
                'message' => 'Account created successfully! A welcome email has been sent.',
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred during registration. Please try again.',
            ], 500);
        }
    }

    /**
     * Handle the logout process.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'You have been logged out successfully.');
    }
}
