<?php

namespace Database\Factories;

use App\Models\Visit;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vitals>
 */
class VitalsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $patient = Patient::inRandomOrder()->first();
        $visit = Visit::inRandomOrder()->first();
        
        return [
            'patient_id' => $patient ? $patient->id : null,
            'visit_id' => $visit ? $visit->id : null,
            'height' => $this->faker->randomFloat(2, 1, 2.5),
            'weight' => $this->faker->randomFloat(2, 30, 150),
            'blood_pressure' => $this->faker->word,
            'temperature' => $this->faker->randomFloat(1, 36, 39),
            'pulse' => $this->faker->numberBetween(60, 100),
        ];
        
    }
}
