<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\Dormitory;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class AdminDormController extends Controller
{
    public function create()
    {
        return view('committee.dormitories.create');
    }

    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls,csv|max:2048',
        ]);

        try {
            $spreadsheet = IOFactory::load($request->file('excel_file')->getRealPath());
            $rows = $spreadsheet->getActiveSheet()->toArray();

            foreach (array_slice($rows, 1) as $row) {
                $dormName       = $row[0] ?? null;
                $ownerName      = $row[1] ?? null;
                $contactNumber  = $row[2] ?? null;
                $email          = $row[3] ?? null;
                $location       = $row[4] ?? null;
                $ownerAddress   = $row[5] ?? null;

                if (!$dormName || !$ownerName || !$email) continue;

                $user = User::firstOrCreate(
                    ['name' => $ownerName],
                    [
                        'email' => $email,
                        'password' => bcrypt('password'),
                        'role' => 'owner',
                    ]
                );

                Dormitory::create([
                    'user_id'        => $user->id,
                    'name'           => $dormName,
                    'contact_number' => $contactNumber,
                    'email'          => $email,
                    'location'       => $location,
                    'owner_address'  => $ownerAddress,
                    'status'         => 'pending',
                ]);
            }

            return back()->with('success', 'Dormitories imported successfully!');
        } catch (\Exception $e) {
            Log::error('Dorm Import Error: ' . $e->getMessage());
            return back()->with('error', 'Failed to import: ' . $e->getMessage());
        }
    }
}
