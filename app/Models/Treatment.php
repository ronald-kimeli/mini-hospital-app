<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    use HasFactory;

    protected $fillable = [
        'visit_id',
        'patient_id',
        'doctor_id',
        'department_id',
        'notes',
        'treatment_provided',
        'date_of_treatment',
        'price',
        'status',
        'doctor_seen',
        'laboratory_seen',
        'radiology_seen',
        'optician_seen',
        'doctor_notes_time',
        'laboratory_notes_time',
        'radiology_notes_time',
        'optician_notes_time',
    ];

    public function visit()
    {
        return $this->belongsTo(Visit::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function referrals()
    {
        return $this->hasMany(Referral::class);
    }
    
}
