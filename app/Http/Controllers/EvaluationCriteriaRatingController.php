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

        // Update accreditation schedule status
        $schedule = AccreditationSchedule::findOrFail($validated['schedule_id']);
        $schedule->status = $validated['final_remarks'];
        $schedule->save();

        // Notify owner
        $dorm = $schedule->dormitory;
        $ownerEmail = $dorm->email;
        $status = $validated['final_remarks'];

        if ($status === 'accredited') {
            // Generate certificate PDF
            $pdf = Pdf::loadView('pdf.certificate', [
                'dorm' => $dorm,
                'date' => now()->format('F d, Y'),
                'effective_date' => now()->format('F d, Y'),
                'expiration_date' => now()->addYear()->format('F d, Y'),
            ]);

            $pdfPath = 'certificates/' . $dorm->id . '_certificate.pdf';
            Storage::put('public/' . $pdfPath, $pdf->output());

            // Send email with attachment
            Mail::to($ownerEmail)->send(new DormitoryAccreditationResult($dorm, $pdfPath));
        } else {
            // Send email without attachment
            Mail::to($ownerEmail)->send(new DormitoryAccreditationResult($dorm));
        }

        // Optional: Send SMS (you can integrate your SMS gateway here)
        // e.g., SmsService::send($dorm->contact_number, "Your dormitory status: $status");

        return redirect()->route('evaluation.schedules')->with('success', 'Evaluation submitted and status updated.');
    }
}
