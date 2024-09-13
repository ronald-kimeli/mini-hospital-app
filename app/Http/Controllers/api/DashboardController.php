<?php

namespace App\Http\Controllers\api;

use Carbon\Carbon;
use App\Models\Visit;
use App\Models\Patient;
use App\Models\Treatment;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{

    public function getUniversalSummary(): JsonResponse
    {
        // Total number of patients
        $totalPatients = Patient::count();

        // Total visits (both active and completed)
        $totalVisits = Visit::count();

        // Active visits (where check_out_time is null)
        $activeVisits = Visit::whereNull('check_out_time')->count();

        // Completed visits (where checked_out = true)
        $completedVisits = Visit::where('checked_out', true)->count();

        // Pending treatments (example status 'pending')
        $pendingTreatments = Treatment::where('status', 'pending')->count();

        // Total treatments across all patients
        $totalTreatments = Treatment::count();

        // Visits today
        $todayVisits = Visit::whereDate('check_in_time', Carbon::today())->count();

        // Cash derived from completed treatments
        $totalCashReceived = Treatment::where('status', 'completed')->sum('price');

        // Total pending payments for treatments
        $totalPendingPayments = Treatment::where('status', 'pending')->sum('price');

        // Treatments by department
        $treatmentsByDepartment = Treatment::selectRaw('department_id, COUNT(*) as count')
            ->groupBy('department_id')
            ->get()
            ->map(function ($treatment) {
                return [
                    'department' => Department::find($treatment->department_id)->name,
                    'count' => $treatment->count
                ];
            });

        // Visits by date
        $visitsByDate = Visit::selectRaw('DATE(check_in_time) as date, COUNT(*) as count')
            ->groupBy('date')
            ->get()
            ->map(function ($visit) {
                return [
                    'date' => $visit->date,
                    'count' => $visit->count
                ];
            });

        // Summary as a unified response
        $summary = [
            'total_patients' => $totalPatients,
            'total_visits' => $totalVisits,
            'active_visits' => $activeVisits,
            'completed_visits' => $completedVisits,
            'pending_treatments' => $pendingTreatments,
            'total_treatments' => $totalTreatments,
            'today_visits' => $todayVisits,
            'total_cash_received' => $totalCashReceived,
            'total_pending_payments' => $totalPendingPayments,
            'treatments_by_department' => $treatmentsByDepartment,
            'visits_by_date' => $visitsByDate
        ];

        return response()->json([
            'success' => true,
            'message' => 'Universal dashboard summary fetched successfully',
            'data' => $summary
        ], 200);
    }


}
