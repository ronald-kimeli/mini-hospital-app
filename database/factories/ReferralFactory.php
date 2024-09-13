<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Patient;
use App\Models\Treatment;
use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Referral>
 */
class ReferralFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $patient = Patient::inRandomOrder()->first();
        $treatment = Treatment::inRandomOrder()->first();
        $department = Department::inRandomOrder()->first();
        $user = User::inRandomOrder()->first();
        
        return [
            'patient_id' => $patient ? $patient->id : null,
            'treatment_id' => $treatment ? $treatment->id : null,
            'referral_department_id' => $department ? $department->id : null,
            'date_of_referral' => $this->faker->dateTimeThisYear(),
            'status' => $this->faker->randomElement(['pending', 'completed']),
            'completed_by_id' => $user ? $user->id : null,
            'completed_at' => $this->faker->dateTimeThisYear(),
        ];
        
    }
}
