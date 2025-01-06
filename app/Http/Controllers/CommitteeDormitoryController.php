<?php

namespace App\Http\Controllers;

use App\Models\Dormitory;
use Illuminate\Http\Request;

class CommitteeDormitoryController extends Controller
{
    /**
     * Display a listing of dormitories for committee users.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Fetch all dormitories (can add filters as needed)
        $dormitories = Dormitory::orderBy('created_at', 'desc')->get();

        return view('committee.dormitories', compact('dormitories'));
    }

    /**
     * Store a newly created dormitory in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate incoming request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'owner_id' => 'required|exists:users,id',
            'status' => 'required|in:pending,accredited,rejected',
        ]);

        // Create a new dormitory
        Dormitory::create($validated);

        return redirect()
            ->route('committee.dormitories')
            ->with('success', 'Dormitory added successfully!');
    }

    /**
     * Remove the specified dormitory from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $dormitory = Dormitory::findOrFail($id);

        $dormitory->delete();

        return redirect()
            ->route('committee.dormitories')
            ->with('success', 'Dormitory deleted successfully!');
    }
}
