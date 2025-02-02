<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Department>
 */
class DepartmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $departments = [
            'Nursing',
            'Laboratory',
            'Radiology',
            'Treatment',
            'Optical',
            'Reception'
        ];

        return [
            'name' => $departments[array_rand($departments)],
            'description' => $this->faker->paragraph,
        ];
    }
}
