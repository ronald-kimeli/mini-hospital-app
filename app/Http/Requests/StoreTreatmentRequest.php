<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTreatmentRequest extends FormRequest
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
            'visit_id' => 'required|exists:visits,id',
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:users,id',
            'department_id' => 'required|exists:departments,id',
            'doctor_notes' => 'nullable|string',
            'laboratory_notes' => 'nullable|string',
            'radiology_notes' => 'nullable|string',
            'optician_notes' => 'nullable|string',
            'doctor_notes_time' => 'nullable|date',
            'laboratory_notes_time' => 'nullable|date',
            'radiology_notes_time' => 'nullable|date',
            'optician_notes_time' => 'nullable|date',
            'treatment_provided' => 'nullable|string',
            'date_of_treatment' => 'required|date',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:pending,completed',
            'doctor_seen' => 'required|boolean',
            'laboratory_seen' => 'required|boolean',
            'radiology_seen' => 'required|boolean',
            'optician_seen' => 'required|boolean',
        ];
    }
}
