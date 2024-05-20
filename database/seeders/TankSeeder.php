<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tank;

class TankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tanks = [
            [
                'type' => 'Panzer IV',
                'speed' => 6,
                'turret_range' => 8,
                'health_points' => 90,
            ],
            [
                'type' => 'T-34',
                'speed' => 7,
                'turret_range' => 7,
                'health_points' => 85,
            ],
            [
                'type' => 'Tiger I',
                'speed' => 5,
                'turret_range' => 9,
                'health_points' => 100,
            ],
            [
                'type' => 'Sherman',
                'speed' => 6,
                'turret_range' => 7,
                'health_points' => 80,
            ],
            [
                'type' => 'Panther',
                'speed' => 7,
                'turret_range' => 8,
                'health_points' => 95,
            ],
            [
                'type' => 'KV-1',
                'speed' => 4,
                'turret_range' => 6,
                'health_points' => 110,
            ],
            [
                'type' => 'M4A3E8',
                'speed' => 6,
                'turret_range' => 8,
                'health_points' => 75,
            ],
            [
                'type' => 'IS-2',
                'speed' => 5,
                'turret_range' => 9,
                'health_points' => 105,
            ],
            [
                'type' => 'Cromwell',
                'speed' => 8,
                'turret_range' => 7,
                'health_points' => 70,
            ],
            [
                'type' => 'Churchill',
                'speed' => 3,
                'turret_range' => 6,
                'health_points' => 120,
            ],
        ];

        foreach ($tanks as $tank) {
            Tank::create($tank);
        }
    }
}
