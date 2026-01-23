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
            'Penyuluhan Kesehatan',
            'Gotong Royong',
            'Senam Sehat',
            'Pelatihan Keterampilan',
            'Bazar PKK',
            'Pembinaan Dasawisma',
            'Sosialisasi Program Kerja',
            'Kunjungan Rumah',
            'Pelatihan UMKM',
            'Penyuluhan Gizi',
        ];

        return [
            'title' => fake()->randomElement($titles),
            'start_date' => fake()->dateTimeBetween('-1 year', 'now'),
            'end_date' => fake()->dateTimeBetween('start_date', 'now'),
        ];
    }
}
