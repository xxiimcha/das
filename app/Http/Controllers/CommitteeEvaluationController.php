<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Evaluation;
use App\Models\EvaluationDetail;

class EvaluationController extends Controller
{
    public function submit(Request $request)
    {
        // Validate the incoming request data.
        $validated = $request->validate([
            'schedule_id'      => 'required|exists:accreditation_schedules,id',
            'evaluator_name'   => 'required|string',
            'evaluation_date'  => 'required|date',
            'criteria'         => 'required|array',
            'criteria.*.rating'=> 'required|integer|between:1,5',
        ]);

        // Begin a transaction for data consistency.
        DB::beginTransaction();

        try {
            // Create the evaluation record.
            $evaluation = Evaluation::create([
                'schedule_id'     => $validated['schedule_id'],
                'evaluator_name'  => $validated['evaluator_name'],
                'evaluation_date' => $validated['evaluation_date'],
            ]);

            // Save each criteria rating.
            foreach ($validated['criteria'] as $criteriaId => $data) {
                EvaluationDetail::create([
                    'evaluation_id' => $evaluation->id,
                    'criteria_id'   => $criteriaId,
                    'rating'        => $data['rating'],
                ]);
            }

            DB::commit();

            return redirect()->route('evaluation.schedules')
                ->with('success', 'Evaluation submitted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors('Error saving evaluation: ' . $e->getMessage());
        }
    }
}
