<?php

namespace App\Http\Controllers\API;

use App\Models\Referral;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReferralRequest;
use App\Http\Requests\UpdateReferralRequest;


class ReferralsController extends Controller
{
    public function index()
    {
        $referrals = Referral::with(['patient', 'treatment', 'referralDepartment', 'completedBy'])->get();
        return response()->json([
            'success' => true,
            'message' => 'Referrals fetched successfully',
            'data' => $referrals
        ], 200);
    }

    public function store(StoreReferralRequest $request)
    {
        $validatedData = $request->validated();
        $referral = Referral::create($validatedData);
        return response()->json([
            'success' => true,
            'message' => 'Referral created successfully',
            'data' => $referral
        ], 201);
    }

    public function show($id)
    {
        try {
            $referral = Referral::findOrFail($id);
            return response()->json([
                'success' => true,
                'message' => 'Referral fetched successfully',
                'data' => $referral
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Referral not found'
            ], 404);
        }
    }

    public function update(UpdateReferralRequest $request, $id)
    {
        try {
            $referral = Referral::findOrFail($id);
            $validatedData = $request->validated();
            $referral->update($validatedData);
            return response()->json([
                'success' => true,
                'message' => 'Referral updated successfully',
                'data' => $referral
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Referral not found'
            ], 404);
        }
    }

    public function destroy($id)
    {
        try {
            $referral = Referral::findOrFail($id);
            $referral->delete();
            return response()->json([
                'success' => true,
                'message' => 'Referral deleted successfully'
            ], 204);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the referral.'
            ], 500);
        }
    }
}
