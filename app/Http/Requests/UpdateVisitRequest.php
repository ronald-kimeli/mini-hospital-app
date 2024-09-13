<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVisitRequest extends FormRequest
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
            'patient_id' => 'sometimes|exists:patients,id',
            'check_in_time' => 'sometimes|date',
            'check_out_time' => 'nullable|date|after:check_in_time',
            'current_stage' => 'sometimes|in:triage,doctor,laboratory,radiology,optical,checked_out',
            'stages' => 'nullable|string',
            'checked_out' => 'sometimes|boolean',
        ];
    }
}
