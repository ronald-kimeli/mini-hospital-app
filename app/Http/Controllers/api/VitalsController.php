<?php

namespace App\Http\Controllers\API;

use App\Models\Vitals;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVitalsRequest;
use App\Http\Requests\UpdateVitalsRequest;


class VitalsController extends Controller
{
    public function index()
    {
        $vitals = Vitals::with(['patient', 'visit'])->get();
        return response()->json([
            'success' => true,
            'message' => 'Vitals fetched successfully',
            'data' => $vitals
        ], 200);
    }

    public function store(StoreVitalsRequest $request)
    {
        $validatedData = $request->validated();
        $vitals = Vitals::create($validatedData);
        return response()->json([
            'success' => true,
            'message' => 'Vitals created successfully',
            'data' => $vitals
        ], 201);
    }

    public function show($id)
    {
        try {
            $vitals = Vitals::with(['patient', 'visit'])->findOrFail($id);
            return response()->json([
                'success' => true,
                'message' => 'Vitals fetched successfully',
                'data' => $vitals,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Vitals not found'
            ], 404);
        }
    }

    public function update(UpdateVitalsRequest $request, $id)
    {
        try {
            $vitals = Vitals::findOrFail($id);
            $validatedData = $request->validated();
            $vitals->update($validatedData);
            return response()->json([
                'success' => true,
                'message' => 'Vitals updated successfully',
                'data' => $vitals
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Vitals not found'
            ], 404);
        }
    }

    public function destroy($id)
    {
        try {
            $vitals = Vitals::findOrFail($id);
            $vitals->delete();
            return response()->json([
                'success' => true,
                'message' => 'Vitals deleted successfully'
            ], 204);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the vitals.'
            ], 500);
        }
    }
}
