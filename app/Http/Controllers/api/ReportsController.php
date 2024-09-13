<?php

namespace App\Http\Controllers\API;

use App\Models\Patient;
use App\Models\Department;
use App\Models\Treatment;
use App\Models\Visit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\PatientsExport;
use App\Exports\DepartmentsExport;
use App\Exports\TreatmentsExport;
use App\Exports\VisitsExport;
use Illuminate\Http\JsonResponse;

class ReportsController extends Controller
{
    // Report for patient summary
    public function patientSummary(): JsonResponse
    {
        $patients = Patient::with(['visits', 'treatments'])->get();

        return response()->json([
            'success' => true,
            'message' => 'Patient summary report generated successfully',
            'data' => $patients
        ], 200);
    }

    // Report for department summary
    public function departmentSummary(): JsonResponse
    {
        $departments = Department::with(['patients', 'visits'])->get();

        return response()->json([
            'success' => true,
            'message' => 'Department summary report generated successfully',
            'data' => $departments
        ], 200);
    }

    // Report for treatment summary
    public function treatmentSummary(): JsonResponse
    {
        $treatments = Treatment::with(['patient', 'department', 'referrals'])->get();

        return response()->json([
            'success' => true,
            'message' => 'Treatment summary report generated successfully',
            'data' => $treatments
        ], 200);
    }

    // Report for visit summary
    public function visitSummary(): JsonResponse
    {
        $visits = Visit::with(['patient'])->get();

        return response()->json([
            'success' => true,
            'message' => 'Visit summary report generated successfully',
            'data' => $visits
        ], 200);
    }

    // Export patient summary report
    public function exportPatientSummary($format)
    {
        if ($format === 'pdf') {
            return $this->exportPatientSummaryPDF();
        } elseif ($format === 'excel') {
            return $this->exportPatientSummaryExcel();
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Invalid format specified'
            ], 400);
        }
    }

    // Export department summary report
    public function exportDepartmentSummary($format)
    {
        if ($format === 'pdf') {
            return $this->exportDepartmentSummaryPDF();
        } elseif ($format === 'excel') {
            return $this->exportDepartmentSummaryExcel();
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Invalid format specified'
            ], 400);
        }
    }

    // Export treatment summary report
    public function exportTreatmentSummary($format)
    {
        if ($format === 'pdf') {
            return $this->exportTreatmentSummaryPDF();
        } elseif ($format === 'excel') {
            return $this->exportTreatmentSummaryExcel();
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Invalid format specified'
            ], 400);
        }
    }

    // Export visit summary report
    public function exportVisitSummary($format)
    {
        if ($format === 'pdf') {
            return $this->exportVisitSummaryPDF();
        } elseif ($format === 'excel') {
            return $this->exportVisitSummaryExcel();
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Invalid format specified'
            ], 400);
        }
    }

    // Export patients to Excel
    protected function exportPatientSummaryExcel()
    {
        return Excel::download(new PatientsExport, 'patients.xlsx');
    }

    // Export patients to PDF
    protected function exportPatientSummaryPDF()
    {
        $patients = Patient::all();
        $pdf = Pdf::loadView('reports.patient_summary', compact('patients'));
        return $pdf->download('patients.pdf');
    }

    // Export departments to Excel
    protected function exportDepartmentSummaryExcel()
    {
        return Excel::download(new DepartmentsExport, 'departments.xlsx');
    }

    // Export departments to PDF
    protected function exportDepartmentSummaryPDF()
    {
        $departments = Department::all();
        $pdf = Pdf::loadView('reports.department_summary', compact('departments'));
        return $pdf->download('departments.pdf');
    }

    // Export treatments to Excel
    protected function exportTreatmentSummaryExcel()
    {
        return Excel::download(new TreatmentsExport, 'treatments.xlsx');
    }

    // Export treatments to PDF
    protected function exportTreatmentSummaryPDF()
    {
        $treatments = Treatment::all();
        $pdf = Pdf::loadView('reports.treatment_summary', compact('treatments'));
        return $pdf->download('treatments.pdf');
    }

    // Export visits to Excel
    protected function exportVisitSummaryExcel()
    {
        return Excel::download(new VisitsExport, 'visits.xlsx');
    }

    // Export visits to PDF
    protected function exportVisitSummaryPDF()
    {
        $visits = Visit::all();
        $pdf = Pdf::loadView('reports.visit_summary', compact('visits'));
        return $pdf->download('visits.pdf');
    }
}
