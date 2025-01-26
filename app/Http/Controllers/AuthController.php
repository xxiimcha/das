<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\User;
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

         // Log the login attempt
         Log::info('Login attempt received', [
             'email' => $request->email,
             'entered_password' => $request->password,
         ]);

         if (Auth::attempt($credentials)) {
             // Regenerate session for security
             $request->session()->regenerate();

             // Get the authenticated user's role
             $user = Auth::user();
             $role = $user->role;

             // Log the successful login
             Log::info('Login successful', [
                 'user_id' => $user->id,
                 'role' => $role,
             ]);

             // Redirect based on user role
             switch ($role) {
                 case 'admin':
                     return redirect()->route('dashboard')->with('success', 'Welcome to the Admin Dashboard!');
                 case 'committee':
                     return redirect()->route('committee.dashboard')->with('success', 'Welcome to the Committee Dashboard!');
                 case 'owner':
                     return redirect()->route('owner.dashboard')->with('success', 'Welcome to the Owner Dashboard!');
                 case 'user':
                     return redirect('/')->with('success', 'Welcome back, ' . $user->name . '!');
                 default:
                     Auth::logout(); // Log out unauthorized roles
                     Log::warning('Unauthorized role detected', ['user_id' => $user->id, 'role' => $role]);
                     return redirect()->route('login')->with('error', 'Unauthorized role. Please contact the administrator.');
             }
         }

         // Log the failed login attempt
         Log::warning('Login failed: Invalid credentials', [
             'email' => $request->email,
         ]);

         return back()->with('error', 'Invalid login credentials.');
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
            // Hash the password once
            $hashedPassword = Hash::make($request->password);

            // Log the hashed password
            Log::info('Hashing password for user registration.', [
                'email' => $request->email,
                'plaintext_password' => $request->password,
                'hashed_password' => $hashedPassword,
            ]);

            // Directly insert the data into the database
            DB::table('users')->insert([
                'name' => $request->firstname . ' ' . $request->lastname,
                'email' => $request->email,
                'role' => 'user',
                'password' => $hashedPassword,
            ]);

            Log::info('User registration successful with direct DB insert.', [
                'email' => $request->email,
                'hashed_password_saved' => $hashedPassword,
            ]);

            // Send Welcome Email
            Mail::to($request->email)->send(new WelcomeEmail($request->firstname . ' ' . $request->lastname));

            return response()->json([
                'success' => true,
                'message' => 'Account created successfully! A welcome email has been sent.',
            ], 201);
        } catch (\Exception $e) {
            Log::error('Registration failed.', [
                'error' => $e->getMessage(),
                'email' => $request->email,
            ]);

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
