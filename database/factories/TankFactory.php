<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tank>
 */
class TankFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => fake()->word,
            'speed' => fake()->numberBetween(1, 10),
            'turret_range' => fake()->numberBetween(1, 10),
            'health_points' => fake()->numberBetween(1, 100),
        ];
    }
}
