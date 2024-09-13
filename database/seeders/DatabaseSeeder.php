<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Visit;
use App\Models\Vitals;
use App\Models\Patient;
use App\Models\Referral;
use App\Models\Treatment;
use App\Models\Department;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        if (Department::count() === 0) {
            Department::factory(6)->create();
        }

        if (Role::count() === 0) {
            Role::factory(6)->create();
        }

        User::factory(count: 3)->create();

        if (!User::where('email', 'admin@gmail.com')->exists()) {
            User::create([
                'name' => 'Test User',
                'email' => 'admin@gmail.com',
                'role_id' => 2,
                'department_id' => 2,
                'password' => Hash::make('12345678'),
            ]);
        }

        Patient::factory(count: 3)->create();
        Visit::factory(count: 3)->create();
        Treatment::factory(count: 3)->create();
        Referral::factory(count: 3)->create();
        Vitals::factory(count: 3)->create();
        Permission::factory(count: 3)->create();
    }
}
