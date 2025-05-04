<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Criteria;
use App\Models\CriteriaColumn;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\DB;

class CommitteeCriteriaController extends Controller
{
    // Display criteria and columns
    public function index()
    {
        $columns = CriteriaColumn::select('id', 'name')->get();
        $criteria = Criteria::select('id', 'criteria_name', 'values', 'status')->get();

        $criteria->map(function ($item) {
            if (is_string($item->values)) {
                $item->values = json_decode($item->values, true);
            }
            return $item;
        });

        return view('committee.criteria', compact('columns', 'criteria'));
    }
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);
    
        $file = $request->file('file');
        $spreadsheet = IOFactory::load($file->getPathname());
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray(null, true, true, true);
    
        // 1. Extract column headers from row 1 (columns B–E)
        $columnHeaders = [
            $rows[1]['B'] ?? 'Totally Unacceptable',
            $rows[1]['C'] ?? 'Slightly Acceptable',
            $rows[1]['D'] ?? 'Acceptable',
            $rows[1]['E'] ?? 'Completely Acceptable',
        ];
    
        CriteriaColumn::truncate();
        foreach ($columnHeaders as $header) {
            if (!empty($header)) {
                CriteriaColumn::create(['name' => trim($header)]);
            }
        }
    
        // 2. Clear old criteria without violating FK constraints
        Criteria::query()->delete();
        DB::statement('ALTER TABLE criteria AUTO_INCREMENT = 1');
    
        // 3. Import criteria data starting from row 2
        for ($i = 2; $i <= count($rows); $i++) {
            $row = $rows[$i] ?? [];
    
            $criteriaName = trim($row['A'] ?? '');
    
            // Check if it's a valid rubric (e.g. "1.1." or "2.2.")
            if (str_contains($criteriaName, '.') && !empty($criteriaName)) {
                $values = [
                    $row['B'] ?? '',
                    $row['C'] ?? '',
                    $row['D'] ?? '',
                    $row['E'] ?? '',
                ];
    
                Criteria::create([
                    'criteria_name' => $criteriaName,
                    'values' => json_encode($values),
                    'status' => 1,
                ]);
            }
        }
    
        return redirect()->back()->with('success', 'Criteria imported successfully.');
    }
    

    // Update specific cell in criteria
    public function updateCell(Request $request)
    {
        $criteria = Criteria::findOrFail($request->id);
        $values = json_decode($criteria->values, true);
        $values[$request->column_index - 1] = $request->value;
        $criteria->values = json_encode($values);
        $criteria->save();

        return response()->json(['success' => true]);
    }

    // Toggle criteria status
    public function toggleStatus(Request $request)
    {
        $criteria = Criteria::findOrFail($request->id);
        $criteria->status = $request->status;
        $criteria->save();

        return response()->json(['success' => true, 'status' => $criteria->status]);
    }
}
