<?php

namespace App\Http\Controllers;

use App\Models\Dormitory;
use App\Models\AccreditationSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommitteeDashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id(); // get currently logged-in committee user's ID

        // Count dormitories assigned to the committee
        $totalDormitories = Dormitory::where('committee_id', $userId)->count();

        // Count dormitories under the committee with 'pending' status
        $pendingDormitories = Dormitory::where('committee_id', $userId)->where('status', 'pending')->count();

        // Count accredited dormitories under the committee
        $accreditedDormitories = Dormitory::where('committee_id', $userId)->where('status', 'accredited')->count();

        // Count schedules with status 'pending' for dorms handled by this committee
        $pendingAccreditations = AccreditationSchedule::whereHas('dormitory', function ($query) use ($userId) {
            $query->where('committee_id', $userId);
        })->where('status', 'pending')->count();

        // List of dormitories under this committee pending approval
        $pendingDormitoriesList = Dormitory::where('committee_id', $userId)
            ->where('status', 'pending')
            ->with('owner')
            ->get();

        // List of dormitories under this committee pending accreditation
        $pendingAccreditationList = Dormitory::where('committee_id', $userId)
            ->where('status', 'pending accreditation')
            ->with(['owner', 'accreditationSchedules' => function ($query) {
                $query->orderBy('evaluation_date', 'desc');
            }])->get();

        return view('committee.dashboard', compact(
            'totalDormitories',
            'pendingDormitories',
            'accreditedDormitories',
            'pendingAccreditations',
            'pendingDormitoriesList',
            'pendingAccreditationList'
        ));
    }
}
