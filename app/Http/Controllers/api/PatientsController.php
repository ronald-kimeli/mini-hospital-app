<?php

namespace App\Http\Controllers\API;

use App\Models\Patient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\PatientsExport;

class PatientsController extends Controller
{
    // Get all patients
    public function index()
    {
        $patients = Patient::all();
        return response()->json([
            'success' => true,
            'message' => 'Patients fetched successfully',
            'data' => $patients
        ], 200);
    }

    // Store a new patient
    public function store(StorePatientRequest $request)
    {
        $validatedData = $request->validated();
        $patient = Patient::create($validatedData);
        return response()->json([
            'success' => true,
            'message' => 'Patient created successfully',
            'data' => $patient
        ], 201);
    }

    // Show a specific patient by ID
    public function show($id)
    {
        try {
            $patient = Patient::findOrFail($id);
            return response()->json([
                'success' => true,
                'message' => 'Patient fetched successfully',
                'data' => $patient
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Patient not found'
            ], 404);
        }
    }

    // Update a specific patient by ID
    public function update(UpdatePatientRequest $request, $id)
    {
        try {
            $patient = Patient::findOrFail($id);
            $validatedData = $request->validated();
            $patient->update($validatedData);
            return response()->json([
                'success' => true,
                'message' => 'Patient updated successfully',
                'data' => $patient
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Patient not found'
            ], 404);
        }
    }

    // Delete a specific patient by ID
    public function destroy($id)
    {
        try {
            $patient = Patient::findOrFail($id);
            $patient->delete();
            return response()->json([
                'success' => true,
                'message' => 'Patient deleted successfully'
            ], 204);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the patient.'
            ], 500);
        }
    }

    // Custom route for filtering patients by name or id_number
    public function filterPatients(Request $request)
    {
        $query = Patient::query();

        // Filter by name if provided
        if ($request->has('name') && $request->name != '') {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        // Filter by id_number if provided
        if ($request->has('id_number') && $request->id_number != '') {
            $query->where('id_number', $request->id_number);
        }

        // Get the filtered patients
        $patients = $query->get();

        // Return response with filtered patients
        return response()->json([
            'success' => true,
            'message' => 'Patients filtered successfully',
            'data' => $patients
        ], 200);
    }

    // Export patients to PDF
    public function exportPDF()
    {
        // Retrieve all patients and eager load related visits
        $patients = Patient::with('visits')->get();

        // Check if data was retrieved
        if ($patients->isEmpty()) {
            return response()->json(['message' => 'No patients found.'], 404);
        }

        // Load the view with the data
        $pdf = Pdf::loadView('patients.pdf', ['patients' => $patients]);

        // Optional: Set paper size and orientation if needed
        $pdf->setPaper('A4', 'portrait');

        // Return the generated PDF as a download
        return $pdf->download('patients.pdf');
    }
}
