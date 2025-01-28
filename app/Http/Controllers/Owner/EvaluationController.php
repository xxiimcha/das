<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Dormitory;
use App\Models\AccreditationSchedule;
use App\Models\Criteria;
use App\Models\CriteriaColumn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


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
        $schedules = AccreditationSchedule::with('dormitory')->get();
        $criterias = Criteria::all();
        $criteriaColumns = CriteriaColumn::all();

        return view('committee.evaluation.index', compact('schedules', 'criterias', 'criteriaColumns'));
    }

    public function showForm(Request $request)
    {
        $scheduleId = $request->query('schedule_id');
        $schedule = AccreditationSchedule::with('dormitory')->findOrFail($scheduleId);
        $criterias = Criteria::all();
        $criteriaColumns = CriteriaColumn::all();
        $evaluatorName = Auth::user()->name ?? 'Guest';
        $evaluationDate = now()->format('Y-m-d\TH:i');

        return view('committee.evaluation.form', compact('schedule', 'criterias', 'criteriaColumns', 'evaluatorName', 'evaluationDate'));
    }

}
