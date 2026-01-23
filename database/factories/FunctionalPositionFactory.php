<?php

namespace Database\Factories;

use App\Models\MemberRole;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FunctionalPosition>
 */
class FunctionalPositionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement([
                'TP PKK',
                'Kader Umum',
                'Kader Khusus',
            ]),
        ];
    }
}
