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

        $locations = [
            'Balai RW 01',
            'Balai RW 02',
            'Aula Kelurahan',
            'Posyandu Melati 1',
            'Posyandu Melati 2',
            'Posyandu Mawar',
            'Kantor Sekretariat PKK',
            'Lapangan Kelurahan',
            'Gedung Serbaguna',
            'Rumah Ketua RT',
        ];

        return [
            'title' => fake()->randomElement($titles),
            'date' => fake()->dateTimeBetween('-1 year', 'now'),
            'location' => fake()->randomElement($locations),
            'description' => fake()->paragraph(3),
        ];
    }
}
