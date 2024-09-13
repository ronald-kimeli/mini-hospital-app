<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'treatment_id',
        'referral_department_id',
        'date_of_referral',
        'status',
        'completed_by_id',
        'completed_at',
    ];
    
    public function patient() {
        return $this->belongsTo(Patient::class);
    }

    public function department() {
        return $this->belongsTo(related: Department::class);
    }
    
    public function treatment() {
        return $this->belongsTo(Treatment::class);
    }
    
    public function referralDepartment() {
        return $this->belongsTo(Department::class, 'referral_department_id');
    }
    
    public function completedBy() {
        return $this->belongsTo(User::class, 'completed_by_id');
    }
    
}
