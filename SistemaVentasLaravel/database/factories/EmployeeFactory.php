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
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->unique()->phoneNumber(),
            'address' => fake()->address(),
            'experience' => fake()->randomElement(['0 Años', '1 Año', '2 Años', '3 Años', '4 Años', '5 Años', '6 Años' ,'7 Años', '8 Años', '9 Años', '10 Años']),
            'salary' => fake()->randomNumber(3, true),
            'vacation' => fake()->randomDigit() ,
            'city' => fake()->city(),
        ];
    }
}
