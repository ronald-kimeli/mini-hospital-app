<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vitals extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'visit_id',
        'height',
        'weight',
        'blood_pressure',
        'temperature',
        'pulse',
    ];
    
    public function patient() {
        return $this->belongsTo(Patient::class);
    }
    
    public function visit() {
        return $this->belongsTo(Visit::class);
    }
    
}
