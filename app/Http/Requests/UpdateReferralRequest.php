<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReferralRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'patient_id' => 'required|exists:patients,id',
            'treatment_id' => 'required|exists:treatments,id',
            'referral_department_id' => 'required|exists:departments,id',
            'date_of_referral' => 'required|date',
            'status' => 'required|in:pending,completed',
            'completed_by_id' => 'nullable|exists:users,id',
            'completed_at' => 'nullable|date',
        ];
    }
}
