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
        $columns = CriteriaColumn::all(); // Fetch all dynamic columns
        $criteria = Criteria::all(); // Fetch all criteria rows

        return response()->json([
            'columns' => $columns,
            'criteria' => $criteria,
        ]);
    }

    /**
     * Save a new column.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveColumn(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        CriteriaColumn::create(['name' => $request->name]);

        return response()->json(['success' => 'Column added successfully!']);
    }

    /**
     * Save a new row.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveRow(Request $request)
    {
        $request->validate([
            'criteria_name' => 'required|string|max:255',
            'values' => 'nullable|array', // Dynamic values for each column
        ]);

        Criteria::create([
            'criteria_name' => $request->criteria_name,
            'values' => json_encode($request->values),
        ]);

        return response()->json(['success' => 'Row added successfully!']);
    }

    /**
     * Delete a row.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteRow($id)
    {
        $criteria = Criteria::findOrFail($id);
        $criteria->delete();

        return response()->json(['success' => 'Row deleted successfully!']);
    }
}
