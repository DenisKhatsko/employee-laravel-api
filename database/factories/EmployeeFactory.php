<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name,
            'age' => fake()->numberBetween(16,80),
            'country' => fake()->country,
            'email' => fake()->safeEmail,
            'salary' => fake()->numberBetween(100, 10000),
            'position' => fake()->jobTitle,
        ];
    }
}
