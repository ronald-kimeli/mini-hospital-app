<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'nursing',
            'laboratory',
            'radiology',
            'treatment',
            'optical',
            'reception'
        ];

        foreach ($roles as $roleName) {
            // Use firstOrCreate to ensure the role is created only if it doesn't exist
            Role::firstOrCreate([
                'name' => $roleName,
            ]);
        }
       
    }
}
