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

}
