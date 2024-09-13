<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_number',
        'name',
        'date_of_birth',
        'gender',
        'phone_number',
        'email',
    ];
    

    public function visits() {
        return $this->hasMany(Visit::class);
    }
    
    public function treatments() {
        return $this->hasMany(Treatment::class);
    }
    
    public function vitals() {
        return $this->hasMany(Vitals::class);
    }
    
    public function referrals() {
        return $this->hasMany(Referral::class);
    }
    
}
