<?php

namespace App\Http\Controllers\API;

use App\Models\Treatment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTreatmentRequest;
use App\Http\Requests\UpdateTreatmentRequest;


class TreatmentsController extends Controller
{
    public function index()
    {
        $treatments = Treatment::with(['patient', 'doctor', 'department'])->get();
        return response()->json([
            'success' => true,
            'message' => 'Treatments fetched successfully',
            'data' => $treatments
        ], 200);
    }

    public function store(StoreTreatmentRequest $request)
    {
        $validatedData = $request->validated();
        $treatment = Treatment::create($validatedData);
        return response()->json([
            'success' => true,
            'message' => 'Treatment created successfully',
            'data' => $treatment
        ], 201);
    }

    public function show($id)
    {
        try {
            $treatment = Treatment::findOrFail($id);
            return response()->json([
                'success' => true,
                'message' => 'Treatment fetched successfully',
                'data' => $treatment
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Treatment not found'
            ], 404);
        }
    }

    public function update(UpdateTreatmentRequest $request, $id)
    {
        try {
            $treatment = Treatment::findOrFail($id);
            $validatedData = $request->validated();
            $treatment->update($validatedData);
            return response()->json([
                'success' => true,
                'message' => 'Treatment updated successfully',
                'data' => $treatment
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Treatment not found'
            ], 404);
        }
    }

    public function destroy($id)
    {
        try {
            $treatment = Treatment::findOrFail($id);
            $treatment->delete();
            return response()->json([
                'success' => true,
                'message' => 'Treatment deleted successfully'
            ], 204);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the treatment.'
            ], 500);
        }
    }
}
