<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Criteria;
use App\Models\CriteriaColumn;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CommitteeCriteriaController extends Controller
{
    // Display criteria and columns
    public function index()
    {
        $columns = CriteriaColumn::select('id', 'name')->get();
        $criteria = Criteria::whereNull('archived_at')
            ->select('id', 'criteria_name', 'values', 'status')
            ->get();

        $criteria->map(function ($item) {
            if (is_string($item->values)) {
                $item->values = json_decode($item->values, true);
            }
            return $item;
        });

        $archivedBatches = Criteria::whereNotNull('archived_at')
            ->select('batch_id')
            ->distinct()
            ->get();

        return view('committee.criteria', compact('columns', 'criteria', 'archivedBatches'));
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

        // 1. Archive old criteria AND set their status to inactive
        Criteria::whereNull('archived_at')->update([
            'archived_at' => now(),
            'status' => 0
        ]);

        // 2. Set a new batch ID
        $batchId = Str::uuid()->toString();

        // 3. Rebuild columns
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

        // 4. Insert new criteria with batch ID
        for ($i = 2; $i <= count($rows); $i++) {
            $row = $rows[$i] ?? [];

            $criteriaName = trim($row['A'] ?? '');
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
                    'batch_id' => $batchId,
                ]);
            }
        }

        return redirect()->back()->with('success', 'New criteria imported. Previous records archived and marked as inactive.');
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

    public function restore($batchId)
    {
        // Archive current active batch and set to inactive
        Criteria::whereNull('archived_at')->update([
            'archived_at' => now(),
            'status' => 0
        ]);

        // Restore selected archived batch and set to active
        Criteria::where('batch_id', $batchId)->update([
            'archived_at' => null,
            'status' => 1
        ]);

        return redirect()->back()->with('success', 'Archived criteria batch restored successfully and activated.');
    }


}
