<?php

namespace App\Http\Controllers;

use App\Models\Dormitory;

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
        $recentDormitories = Dormitory::orderBy('created_at', 'desc')->take(5)->get();

        return view('committee.dashboard', compact(
            'totalDormitories',
            'pendingDormitories',
            'accreditedDormitories',
            'recentDormitories'
        ));
    }
}
