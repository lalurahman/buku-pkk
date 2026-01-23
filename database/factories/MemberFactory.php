<?php

namespace Database\Factories;

use App\Models\FunctionalPosition;
use App\Models\Member;
use App\Models\MemberRole;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Member>
 */
class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name('female'),
            'registration_number' => fake()->unique()->numerify('PKK-####-####'),
            'member_role_id' => MemberRole::inRandomOrder()->first()?->id ?? MemberRole::factory(),
            'functional_position_id' => FunctionalPosition::inRandomOrder()->first()?->id ?? FunctionalPosition::factory(),
            'date_of_birth' => fake()->dateTimeBetween('-60 years', '-20 years'),
            'marital_status' => fake()->randomElement(['Belum Menikah', 'Menikah', 'Cerai Hidup', 'Cerai Mati']),
            'address' => fake()->address(),
            'phone_number' => fake()->numerify('08##########'),
            'education' => fake()->randomElement(['SD', 'SMP', 'SMA', 'D3', 'S1', 'S2', 'S3']),
            'job' => fake()->randomElement(['Ibu Rumah Tangga', 'Guru', 'Pegawai Swasta', 'Wiraswasta', 'PNS', 'Petani', 'Pedagang']),
            'position' => fake()->randomElement(['Ketua RT', 'Ketua RW', 'Anggota', 'Koordinator Dasawisma', null]),
            'status' => fake()->randomElement(['active', 'inactive']),
        ];
    }
}
