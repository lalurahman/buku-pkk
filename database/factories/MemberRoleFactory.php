<?php

namespace Database\Factories;

use App\Models\MemberRole;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MemberRole>
 */
class MemberRoleFactory extends Factory
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
                'Ketua',
                'Wakil Ketua',
                'Sekretaris',
                'Bendahara',
                'Anggota',
            ]),
        ];
    }
}
