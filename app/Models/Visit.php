<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'check_in_time',
        'check_out_time',
        'current_stage',
        'stages',       
        'checked_out',  
    ];
    

    public function patient() {
        return $this->belongsTo(Patient::class);
    }
    
    public function treatments() {
        return $this->hasMany(Treatment::class);
    }
    
    public function vitals() {
        return $this->hasMany(Vitals::class);
    }
    
}
