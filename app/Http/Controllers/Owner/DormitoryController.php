<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Dormitory;

class DormitoryController extends Controller
{
    public function index()
    {
        $dormitories = Dormitory::where('user_id', Auth::id())->get();
        return view('owner.dormitories.index', compact('dormitories'));
    }
}
