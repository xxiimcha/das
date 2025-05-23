<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Dormitory;
use App\Models\AccreditationSchedule;
use Illuminate\Support\Facades\Log;
use App\Models\Criteria;
use App\Models\CriteriaColumn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Evaluation;
use App\Models\EvaluationDetail;
use App\Models\User;
use App\Mail\EvaluationResultMail;
use Illuminate\Support\Facades\Mail;

class EvaluationController extends Controller
{
    public function index()
    {
        $ownerId = Auth::id(); // current logged-in owner

        // Fetch dormitories owned by this user with evaluator, latest schedule, ratings and criteria
        $dormitories = Dormitory::with([
            'committee',
            'accreditationSchedules' => function ($query) {
                $query->latest()->limit(1); // get only the latest schedule
            },
            'accreditationSchedules.ratings.criteria' // load criteria relationship
        ])
        ->where('user_id', $ownerId)
        ->get();

        // Process average ratings and evaluator display
        foreach ($dormitories as $dormitory) {
            $schedule = $dormitory->accreditationSchedules->first();

            if ($schedule && $schedule->ratings->count()) {
                $ratings = $schedule->ratings->pluck('rating')->filter()->map(function ($rate) {
                    return is_numeric($rate) ? floatval($rate) : 0;
                });

                $dormitory->average_rating = $ratings->avg();
            } else {
                $dormitory->average_rating = null;
            }

            $dormitory->evaluator = optional($dormitory->committee)->name ?? 'Unassigned';
        }

        return view('owner.evaluation.index', compact('dormitories'));
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
        $criteria = Criteria::all();
        $criteriaColumns = CriteriaColumn::all();

        return view('committee.evaluation.index', compact('schedules', 'criteria', 'criteriaColumns'));
    }

    public function showForm(Request $request)
    {
        $scheduleId = $request->query('schedule_id');
        $schedule = AccreditationSchedule::with('dormitory')->findOrFail($scheduleId);

        // Get the first active criteria to extract the batch_id
        $firstCriteria = Criteria::where('status', 1)->first();

        if (!$firstCriteria) {
            abort(404, 'No active criteria found.');
        }

        $batchId = $firstCriteria->batch_id;

        // Fetch all active criteria with the same batch
        $criteria = Criteria::where('status', 1)
            ->where('batch_id', $batchId)
            ->get();

        $criteriaColumns = CriteriaColumn::all();
        $evaluatorName = Auth::user()->name ?? 'Guest';
        $evaluationDate = now()->format('Y-m-d\TH:i');

        return view('committee.evaluation.form', compact(
            'schedule',
            'criteria',
            'criteriaColumns',
            'evaluatorName',
            'evaluationDate',
            'batchId'
        ));
    }


    public function review($schedule_id)
    {
        // Load the schedule with all evaluation ratings
        $schedule = AccreditationSchedule::with([
            'dormitory',
            'ratings.criteria' => function ($query) {
                $query->select('criteria.id', 'criteria_name', 'values');
            }
        ])->findOrFail($schedule_id);

        // Get all criteria for displaying maximum columns
        $criteria = Criteria::all();

        return view('committee.evaluation.review', compact('schedule', 'criteria'));
    }
    
    public function submitReview(Request $request, $schedule_id)
    {
        $validated = $request->validate([
            'remarks' => 'nullable|string|max:1000',
            'decision' => 'required|in:pass,fail',
        ]);
    
        // Find the schedule
        $schedule = AccreditationSchedule::findOrFail($schedule_id);
        $schedule->status = $request->decision == 'pass' ? 'passed' : 'failed';
        $schedule->save();
    
        // Find and update the evaluation record
        $evaluation = Evaluation::where('schedule_id', $schedule_id)->first();
        if ($evaluation) {
            $evaluation->remarks = $request->remarks;
            $evaluation->save();
        }
    
        // Find the associated dormitory and load the owner
        $dormitory = Dormitory::where('id', $schedule->dormitory_id)->with('owner')->first();
        if ($dormitory) {
            // Update dormitory status
            $dormitory->status = $request->decision == 'pass' ? 'accredited' : 'reevaluate';
            $dormitory->save();
    
            // Check if dormitory has a valid owner
            if ($dormitory->owner) {
                // Send email notification to the owner
                Mail::to($dormitory->owner->email)->send(new EvaluationResultMail($dormitory, $schedule));
            }
        }
    
        return redirect()->route('evaluation.schedules')->with('success', 'Evaluation reviewed successfully, and email notification sent.');
    }
    
    public function submit(Request $request)
    {
        // Debugging: Log request data
        Log::info('Received Request:', $request->all());
    
        // Validate the incoming request data.
        $validated = $request->validate([
            'schedule_id'      => 'required|exists:accreditation_schedules,id',
            'evaluator_name'   => 'required|string',
            'evaluation_date'  => 'required|date',
            'criteria'         => 'required|array',
            'criteria.*.rating'=> 'required|integer|between:1,5',
        ]);
    
        // Debugging: Log validated data
        Log::info('Validated Data:', $validated);
    
        try {
            // Create the evaluation record.
            $evaluation = Evaluation::create([
                'schedule_id'     => $validated['schedule_id'],
                'evaluator_name'  => $validated['evaluator_name'],
                'evaluation_date' => $validated['evaluation_date'],
            ]);
    
            // Debugging: Log evaluation insert
            Log::info('Evaluation Inserted:', $evaluation->toArray());
    
            // Save each criteria rating.
            foreach ($validated['criteria'] as $criteriaId => $data) {
                EvaluationDetail::create([
                    'evaluation_id' => $evaluation->id,
                    'criteria_id'   => $criteriaId,
                    'rating'        => $data['rating'],
                ]);
    
                // Debugging: Log criteria insert
                Log::info('Criteria Inserted:', [
                    'evaluation_id' => $evaluation->id,
                    'criteria_id'   => $criteriaId,
                    'rating'        => $data['rating'],
                ]);
            }
    
            // Update accreditation_schedules status to "for review"
            $accreditationSchedule = AccreditationSchedule::find($validated['schedule_id']);
            if ($accreditationSchedule) {
                $accreditationSchedule->status = 'for review';
                $accreditationSchedule->save();
                Log::info("Accreditation schedule ID {$validated['schedule_id']} updated to 'for review'.");
            }
    
            // Update the related dormitory status to "under review"
            if ($accreditationSchedule && $accreditationSchedule->dormitory_id) {
                $dormitory = Dormitory::find($accreditationSchedule->dormitory_id);
                if ($dormitory) {
                    $dormitory->status = 'under review';
                    $dormitory->save();
                    Log::info("Dormitory ID {$dormitory->id} updated to 'under review'.");
                }
            }
    
            // Redirect back to the evaluation page with a success message
            return redirect()->route('evaluation.schedules')->with('success', 'Evaluation submitted successfully.');
    
        } catch (\Exception $e) {
            Log::error('Error inserting evaluation: ' . $e->getMessage());
    
            // Redirect back with an error message
            return redirect()->back()->withErrors(['error' => 'Error saving evaluation. Please try again.']);
        }
    }
}
