<?php

namespace Database\Factories;

use App\Enums\GridState;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Map>
 */
class MapFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Generate random height and width with a minimum of 50
        $height = fake()->numberBetween(50, 100);
        $width = fake()->numberBetween(50, 100);


        $grid = [];
        for ($i = 0; $i < $height; $i++) {
            $row = [];
            for ($j = 0; $j < $width; $j++) {
                $row[] = fake()->randomElement([GridState::Empty->value, GridState::Obstacle->value]);
            }
            $grid[] = $row;
        }

        return [
            'grid' => json_encode($grid),
        ];
    }
}
