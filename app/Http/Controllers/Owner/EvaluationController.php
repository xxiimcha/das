<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Dormitory;
use App\Models\AccreditationSchedule; // Assuming this model exists
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    /**
     * Display a list of all dormitories.
     */
    public function index()
    {
        $dormitories = Dormitory::all(); // Fetch all dormitories
        return view('owner.evaluation.index', compact('dormitories')); // Pass to the view
    }

    /**
     * Show the evaluation details for a specific dormitory.
     */
    public function show($id)
    {
        $dormitory = Dormitory::findOrFail($id); // Fetch dormitory by ID
        $evaluations = $dormitory->evaluations; // Assuming a relation `evaluations` exists

        return view('owner.evaluation.show', compact('dormitory', 'evaluations'));
    }

    /**
     * Display all evaluation schedules.
     */
    public function showEvaluationSchedules()
    {
        // Fetch all schedules using Eloquent
        $schedules = AccreditationSchedule::all(); // Assuming AccreditationSchedule is the model for `accreditation_schedules` table

        return view('committee.evaluation.index', compact('schedules')); // Pass schedules to the view
    }
}
