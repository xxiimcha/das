<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


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
        // Validate the incoming request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|string|in:committee,owner',
            'password' => 'required|string|min:6',
            'status' => 'required|string|in:active,inactive',
        ]);

        // Create a new user in the database
        User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'role' => $validatedData['role'],
            'status' => $validatedData['status'],
            'password' => bcrypt($validatedData['password']),
        ]);

        // Redirect back to the user index with a success message
        return redirect()
            ->route('users.index')
            ->with('success', 'User added successfully!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id); // Find the user by ID
        $user->delete(); // Delete the user

        return redirect()->route('users.index')->with('success', 'User deleted successfully!');
    }
}
