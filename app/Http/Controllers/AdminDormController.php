<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminDormController extends Controller
{
    public function create()
    {
        return view('committee.dormitories.create'); // reusing the committee view for admin
    }

    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,csv|max:2048',
        ]);

        // TODO: Process the uploaded file using Laravel Excel or PhpSpreadsheet
        // You can log file info or dump for testing:
        // dd($request->file('excel_file'));

        return back()->with('success', 'Dormitories imported successfully!');
    }
}
