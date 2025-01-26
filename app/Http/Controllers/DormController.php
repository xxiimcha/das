<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dormitory;

class DormController extends Controller
{
    /**
     * Display a listing of accredited dormitories.
     */
    public function index()
    {
        $dormitories = Dormitory::where('status', 'accredited')->get();
        return view('dormitories', compact('dormitories'));
    }

    /**
     * Show the details of a specific dormitory.
     */
    public function show($id)
    {
        $dormitory = Dormitory::findOrFail($id); // Fetch dormitory by ID
        return view('dormitories.show', compact('dormitory')); // Return the show.blade.php view
    }
}
