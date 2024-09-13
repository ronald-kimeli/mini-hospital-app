<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\RolesController;
use App\Http\Controllers\api\VisitsController;
use App\Http\Controllers\api\VitalsController;
use App\Http\Controllers\api\ReportsController;
use App\Http\Controllers\api\PatientsController;
use App\Http\Controllers\api\DashboardController;
use App\Http\Controllers\api\ReferralsController;
use App\Http\Controllers\api\TreatmentsController;
use App\Http\Controllers\api\DepartmentsController;
use App\Http\Controllers\api\PermissionsController;



# Auth
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Route::get('/user', function (Request $request) {
//     //User Route
//     Route::post('/logout', [AuthController::class, 'logout']);
//     return $request->user();
// })->middleware('auth:sanctum');


Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);


    // Standard resource routes
    Route::apiResource('patients', PatientsController::class);
    Route::apiResource('visits', VisitsController::class);
    Route::apiResource('treatments', TreatmentsController::class);
    Route::apiResource('vitals', VitalsController::class);
    Route::apiResource('referrals', ReferralsController::class);
    Route::apiResource('departments', DepartmentsController::class);
    Route::apiResource('roles', RolesController::class);
    Route::apiResource('permissions', PermissionsController::class);

    // Custom routes
    Route::get('patients/filter', [PatientsController::class, 'filterPatients']);
    Route::get('patients/{id}/visits', [PatientsController::class, 'getPatientVisits']);

    // Report generation routes with export functionality for PDF and Excel
    Route::get('reports/patient-summary', [ReportsController::class, 'patientSummary']);
    Route::get('reports/department-summary', [ReportsController::class, 'departmentSummary']);
    Route::get('reports/treatment-summary', [ReportsController::class, 'treatmentSummary']);
    Route::get('reports/visit-summary', [ReportsController::class, 'visitSummary']);

    // Export routes for PDF and Excel
    Route::get('reports/patient-summary/export/{format}', [ReportsController::class, 'exportPatientSummary']);
    Route::get('reports/department-summary/export/{format}', [ReportsController::class, 'exportDepartmentSummary']);
    Route::get('reports/treatment-summary/export/{format}', [ReportsController::class, 'exportTreatmentSummary']);
    Route::get('reports/visit-summary/export/{format}', [ReportsController::class, 'exportVisitSummary']);

    // Dashboard route for universal summary
    Route::get('dashboard/summary', action: [DashboardController::class, 'getUniversalSummary']);
});







