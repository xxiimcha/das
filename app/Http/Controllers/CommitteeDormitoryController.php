<?php

namespace App\Http\Controllers;

use App\Models\Dormitory;
use Illuminate\Http\Request;
use App\Models\AccreditationSchedule;
use Illuminate\Support\Facades\Mail;
use App\Mail\DormitoryStatusChanged;

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
        $dormitories = Dormitory::with('owner')->orderBy('created_at', 'desc')->get();

        return view('committee.dormitories', compact('dormitories'));
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
            'accreditationSchedules.evaluations.details.criteria'
        ])->findOrFail($id);

        // Get the latest accreditation schedule for status
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
    /**
     * Approve the dormitory and set an accreditation schedule.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approve(Request $request, $id)
    {
        $request->validate([
            'evaluation_date' => 'required|date|after_or_equal:today',
        ]);

        $dormitory = Dormitory::with('owner')->findOrFail($id);

        // Update dormitory status
        $dormitory->status = 'pending accreditation';
        $dormitory->save();

        // Create accreditation schedule
        AccreditationSchedule::create([
            'dormitory_id' => $dormitory->id,
            'evaluation_date' => $request->evaluation_date,
        ]);

        // Send email notification to the owner
        Mail::to($dormitory->owner->email)->send(new DormitoryStatusChanged($dormitory, 'approved', $request->evaluation_date));

        return redirect()
            ->route('committee.dormitories')
            ->with('success', 'Dormitory approved and accreditation schedule set.');
    }

    /**
     * Decline the dormitory with a reason.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function decline(Request $request, $id)
    {
        $request->validate([
            'decline_reason' => 'required|string|max:500',
        ]);

        $dormitory = Dormitory::with('owner')->findOrFail($id);

        // Update dormitory status and reason
        $dormitory->status = 'rejected';
        $dormitory->decline_reason = $request->decline_reason;
        $dormitory->save();

        // Send email notification to the owner
        Mail::to($dormitory->owner->email)->send(new DormitoryStatusChanged($dormitory, 'declined', $request->decline_reason));

        return redirect()
            ->route('committee.dormitories')
            ->with('success', 'Dormitory declined successfully.');
    }
}
