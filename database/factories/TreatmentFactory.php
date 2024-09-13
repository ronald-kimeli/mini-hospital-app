<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Visit;
use App\Models\Patient;
use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Treatment>
 */
class TreatmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $visit = Visit::inRandomOrder()->first();
        $patient = Patient::inRandomOrder()->first();
        $doctor = User::inRandomOrder()->first();
        $department = Department::inRandomOrder()->first();
        
        return [
            'visit_id' => $visit ? $visit->id : null,
            'patient_id' => $patient ? $patient->id : null,
            'doctor_id' => $doctor ? $doctor->id : null,
            'department_id' => $department ? $department->id : null,
            'doctor_notes' => $this->faker->paragraph,
            'laboratory_notes' => $this->faker->paragraph,
            'radiology_notes' => $this->faker->paragraph,
            'optician_notes' => $this->faker->paragraph,
            'doctor_notes_time' => $this->faker->dateTime,
            'laboratory_notes_time' => $this->faker->dateTime,
            'radiology_notes_time' => $this->faker->dateTime,
            'optician_notes_time' => $this->faker->dateTime,
            'treatment_provided' => $this->faker->paragraph,
            'date_of_treatment' => $this->faker->dateTime,
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'status' => $this->faker->randomElement(['pending', 'completed']),
            'doctor_seen' => $this->faker->boolean,
            'laboratory_seen' => $this->faker->boolean,
            'radiology_seen' => $this->faker->boolean,
            'optician_seen' => $this->faker->boolean,
        ];
        
    }
}
