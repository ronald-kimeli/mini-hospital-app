<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];
    

    public function users() {
        return $this->hasMany(User::class);
    }
    
    public function treatments() {
        return $this->hasMany(Treatment::class);
    }
    
    public function referrals() {
        return $this->hasMany(Referral::class);
    }
    
}
