<?php

namespace Database\Factories;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Visit>
 */
class VisitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $patient = Patient::inRandomOrder()->first();

        return [
            'patient_id' => $patient ? $patient->id : null,
            'check_in_time' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'check_out_time' => $this->faker->dateTimeBetween('now', '+1 week'),
            'current_stage' => $this->faker->randomElement(['triage', 'doctor', 'laboratory', 'radiology', 'optical', 'checked_out', 'reception']),
            'stages' => implode(',', $this->faker->randomElements(['triage', 'doctor', 'laboratory', 'radiology', 'optical', 'checked_out', 'reception'], 3)),
            'checked_out' => $this->faker->boolean,
        ];
        
    }
}
