<?php

namespace App\Http\Controllers;

use App\Models\Dormitory;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\AccreditationSchedule;
use Illuminate\Support\Facades\Mail;
use App\Mail\DormitoryStatusChanged;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Mail\DormitoryInvitation;

class CommitteeDormitoryController extends Controller
{
    /**
     * Display a listing of dormitories for committee users.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (Auth::user()->role === 'admin') {
            // Show all dormitories
            $dormitories = Dormitory::with(['owner', 'committee', 'accreditationSchedules'])
                            ->orderBy('created_at', 'desc')
                            ->get();
        } elseif (Auth::user()->role === 'committee') {
            // Show only dormitories assigned to this committee
            $dormitories = Dormitory::with(['owner', 'committee', 'accreditationSchedules'])
                            ->where('committee_id', Auth::id())
                            ->orderBy('created_at', 'desc')
                            ->get();
        } else {
            // Optionally, return unauthorized or empty
            abort(403, 'Unauthorized access.');
        }

        $committees = User::where('role', 'committee')->get();

        return view('committee.dormitories', compact('dormitories', 'committees'));
    }

    /**
     * Display the specified dormitory details.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $dormitory = Dormitory::with([
            'owner',
            'amenities',
            'images',
            'documents',
            'accreditationSchedules.evaluations.details.criteria' // Ensure criteria is included
        ])->findOrFail($id);

        // Get latest accreditation schedule for status
        $schedule = $dormitory->accreditationSchedules->last();
        $status = $schedule ? $schedule->status : 'N/A';

        return view('committee.show-dormitory', compact('dormitory', 'status'));
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
    
    public function sendInvitation(Request $request)
    {
        $request->validate([
            'dormitory_id' => 'required|exists:dormitories,id',
        ]);

        $dormitory = Dormitory::with('owner')->findOrFail($request->dormitory_id);

        // Generate a one-time token and store it
        $token = Str::uuid();
        $dormitory->invitation_token = $token;
        $dormitory->save();

        // Generate registration link
        $registrationUrl = url("/registration?token={$token}&dorm_id={$dormitory->id}");

        // Send email
        Mail::to($dormitory->email)->send(new DormitoryInvitation($dormitory, $registrationUrl));

        return redirect()->back()->with('success', 'Invitation email sent successfully.');
    }
}
