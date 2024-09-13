<?php


namespace App\Http\Controllers\API;

use App\Models\Visit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVisitRequest;
use App\Http\Requests\UpdateVisitRequest;

class VisitsController extends Controller
{
    public function index()
    {
        $visits = Visit::with(['patient'])->get();
        return response()->json([
            'success' => true,
            'message' => 'Visits fetched successfully',
            'data' => $visits
        ], 200);
    }

    public function store(StoreVisitRequest $request)
    {
        $validatedData = $request->validated();
        $visit = Visit::create($validatedData);
        return response()->json([
            'success' => true,
            'message' => 'Visit created successfully',
            'data' => $visit
        ], 201);
    }

    public function show($id)
    {
        try {
            $visit = Visit::with(['patient'])->findOrFail($id);
            return response()->json([
                'success' => true,
                'message' => 'Visit fetched successfully',
                'data' => $visit
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Visit not found'
            ], 404);
        }
    }

    public function update(UpdateVisitRequest $request, $id)
    {
        try {
            $visit = Visit::findOrFail($id);
            $validatedData = $request->validated();
            $visit->update($validatedData);
            return response()->json([
                'success' => true,
                'message' => 'Visit updated successfully',
                'data' => $visit
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Visit not found'
            ], 404);
        }
    }

    public function destroy($id)
    {
        try {
            $visit = Visit::findOrFail($id);
            $visit->delete();
            return response()->json([
                'success' => true,
                'message' => 'Visit deleted successfully'
            ], 204);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the visit.'
            ], 500);
        }
    }
}
