<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Role>
 */
class RoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $roles = [
            'nursing',
            'laboratory',
            'radiology',
            'treatment',
            'optical',
            'reception'
        ];

        return [
            'name' => $roles[array_rand($roles)],
        ];
    }
}
