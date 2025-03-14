<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Criteria;
use App\Models\CriteriaColumn;

class CommitteeCriteriaController extends Controller
{
    /**
     * Display a listing of the criteria.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // Fetch columns from criteria_columns
        $columns = CriteriaColumn::select('id', 'name')->get();

        // Fetch criteria from criterias
        $criteria = Criteria::select('id', 'criteria_name', 'values')->get();

        // Decode JSON values in the 'values' column only if it's a string
        $criteria->map(function ($item) {
            if (is_string($item->values)) {
                $item->values = json_decode($item->values, true);
            }
            return $item;
        });

        // Pass the data to the Blade view
        return view('committee.criteria', compact('columns', 'criteria'));
    }

    public function addRow(Request $request)
    {
        $criteria = Criteria::create([
            'criteria_name' => $request->criteria_name,
            'values' => json_encode($request->values),
        ]);

        return response()->json(['success' => true, 'criteria' => $criteria]);
    }

    public function addColumn(Request $request)
    {
        $column = CriteriaColumn::create([
            'name' => $request->column_name,
        ]);

        return response()->json(['success' => true, 'column' => $column]);
    }

    public function deleteRow($id)
    {
        $criteria = Criteria::findOrFail($id);
        $criteria->delete();

        return response()->json(['success' => true]);
    }


    public function updateCell(Request $request)
    {
        $criteria = Criteria::findOrFail($request->id);
        $values = json_decode($criteria->values, true);
        $values[$request->column_index - 1] = $request->value; // Adjust for column offset
        $criteria->values = json_encode($values);
        $criteria->save();

        return response()->json(['success' => true]);
    }

    public function saveChanges(Request $request)
    {
        $changes = $request->changes;

        foreach ($changes as $change) {
            if ($change['id']) {
                // Update existing row
                $criteria = Criteria::findOrFail($change['id']);
                $values = json_decode($criteria->values, true);
                $values[$change['columnIndex'] - 1] = $change['value']; // Adjust column offset
                $criteria->values = json_encode($values);
                $criteria->save();
            } else {
                // Handle new row creation if necessary
                Criteria::create([
                    'criteria_name' => $change['value'], // Adjust as needed
                    'values' => json_encode([]),
                ]);
            }
        }

        return response()->json(['success' => true]);
    }

    public function toggleStatus(Request $request)
    {
        $criteria = Criteria::findOrFail($request->id);
        $criteria->status = $request->status;
        $criteria->save();

        return response()->json(['success' => true, 'status' => $criteria->status]);
    }

}
