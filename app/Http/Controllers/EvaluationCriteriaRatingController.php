<?php

namespace App\Http\Controllers;

use App\Models\EvaluationCriteriaRating;
use App\Models\AccreditationSchedule;
use App\Models\Dormitory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\DormitoryAccreditationResult;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class EvaluationCriteriaRatingController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'schedule_id' => 'required|exists:accreditation_schedules,id',
            'criteria' => 'required|array',
            'criteria.*.rating' => 'required|integer|min:1|max:4',
            'final_remarks' => 'required|in:accredited,failed'
        ]);

        foreach ($validated['criteria'] as $criteriaId => $data) {
            EvaluationCriteriaRating::updateOrCreate(
                [
                    'schedule_id' => $validated['schedule_id'],
                    'criteria_id' => $criteriaId,
                ],
                [
                    'rating' => $data['rating'],
                ]
            );
        }

        // Update accreditation schedule
        $schedule = AccreditationSchedule::findOrFail($validated['schedule_id']);
        $schedule->status = $validated['final_remarks'];
        $schedule->save();

        // Update related dormitory status
        $dorm = $schedule->dormitory;
        $dorm->status = $validated['final_remarks'];
        $dorm->save();

        // Email logic
        $ownerEmail = $dorm->email;
        $status = $validated['final_remarks'];

        if ($status === 'accredited') {
            $pdf = Pdf::loadView('pdf.certificate', [
                'dorm' => $dorm,
                'date' => now()->format('F d, Y'),
                'effective_date' => now()->format('F d, Y'),
                'expiration_date' => now()->addYear()->format('F d, Y'),
            ]);

            $pdfPath = 'certificates/' . $dorm->id . '_certificate.pdf';
            Storage::put('public/' . $pdfPath, $pdf->output());

            Mail::to($ownerEmail)->send(new DormitoryAccreditationResult($dorm, $pdfPath));
        } else {
            Mail::to($ownerEmail)->send(new DormitoryAccreditationResult($dorm));
        }

        return redirect()->route('evaluation.schedules')->with('success', 'Evaluation submitted and status updated.');
    }

}
