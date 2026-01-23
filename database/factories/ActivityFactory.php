<?php

namespace Database\Factories;

use App\Models\Activity;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Activity>
 */
class ActivityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $titles = [
            'Posyandu Balita',
            'Posyandu Lansia',
            'Pelatihan Kader PKK',
            'Rapat Koordinasi',
            'Lomba Memasak',
        ];

        return [
            // title sesuai dari titles array secara berurutan
            'title' => $titles[$this->faker->unique()->numberBetween(0, count($titles) - 1)],
            'description' => $this->faker->paragraph(),
            'start_date' => fake()->dateTimeBetween('-1 year', 'now'),
            'end_date' => fake()->dateTimeBetween('start_date', 'now'),
        ];
    }
}
