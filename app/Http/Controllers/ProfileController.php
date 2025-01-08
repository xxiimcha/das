<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Show the profile page.
     */
    public function index()
    {
        return view('profile');
    }

    /**
     * Edit the profile page.
     */
    public function edit()
    {
        return view('profile-edit'); // Create this view for editing the profile.
    }

    /**
     * Update the profile.
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . auth()->id(),
        ]);

        $user = auth()->user();
        $user->update($request->only(['name', 'email']));

        return redirect()->route('profile.index')->with('success', 'Profile updated successfully!');
    }
}

