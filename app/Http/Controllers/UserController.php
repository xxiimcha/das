<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Display the user management page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Fetch all users except the currently logged-in user
        $users = User::where('id', '!=', Auth::id())
        ->orderBy('created_at', 'desc')
        ->get();

        return view('admin.users', compact('users'));
    }

    /**
     * Store a new user.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|string|in:committee,owner',
            'status' => 'required|string|in:active,inactive',
        ]);

        $plaintextPassword = 'password123'; // Default password
        $hashedPassword = Hash::make($plaintextPassword);

        // Prepare the user data
        $userData = [
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'role' => $validatedData['role'],
            'status' => $validatedData['status'],
            'password' => $hashedPassword,
        ];

        Log::info('Final user data being inserted', $userData);

        // Save the user and log the saved record
        $user = User::create($userData);

        Log::info('User record after saving', [
            'user_id' => $user->id,
            'hashed_password_in_db' => $user->password,
        ]);

        return redirect()->route('users.index')->with('success', 'User added successfully with default password!');
    }


    /**
     * Delete a user by ID.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id); // Find the user by ID
        $user->delete(); // Delete the user

        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }
}
