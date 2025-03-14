<?php

namespace App\Http\Controllers;

use App\Models\Dormitory;
use App\Models\AccreditationSchedule;

class CommitteeDashboardController extends Controller
{
    /**
     * Show the committee dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $totalDormitories = Dormitory::count();
        $pendingDormitories = Dormitory::where('status', 'pending')->count();
        $accreditedDormitories = Dormitory::where('status', 'accredited')->count();
        $pendingAccreditations = AccreditationSchedule::where('status', 'pending')->count();

        // Fetch the list of pending dormitories for the table
        $pendingDormitoriesList = Dormitory::where('status', 'pending')->with('owner')->get();

        // Fetch the list of pending accreditations for the tab
        $pendingAccreditationList = Dormitory::where('status', 'pending accreditation')
            ->with(['owner', 'accreditationSchedules' => function ($query) {
                $query->orderBy('evaluation_date', 'desc')->first();
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
