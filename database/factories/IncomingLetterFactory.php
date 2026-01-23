<?php

namespace Database\Factories;

use App\Models\IncomingLetter;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\IncomingLetter>
 */
class IncomingLetterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subjects = [
            'Undangan Rapat Koordinasi PKK',
            'Permohonan Bantuan Dana',
            'Laporan Kegiatan Posyandu',
            'Pemberitahuan Kegiatan Lomba',
            'Pengajuan Proposal Kegiatan',
            'Surat Edaran Program Kerja',
            'Permohonan Izin Kegiatan',
            'Laporan Keuangan Triwulan',
            'Undangan Pelatihan Kader',
            'Pemberitahuan Pembinaan',
        ];

        $senders = [
            'Dinas Pemberdayaan Masyarakat',
            'Kecamatan Setempat',
            'Kelurahan/Desa',
            'TP PKK Provinsi',
            'TP PKK Kabupaten',
            'Puskesmas',
            'Camat',
            'Lurah/Kepala Desa',
            'BKKBN',
            'Dinas Kesehatan',
        ];

        return [
            'letter_number' => fake()->unique()->numerify('###/SM/PKK/####'),
            'received_date' => fake()->dateTimeBetween('-6 months', 'now'),
            'letter_date' => fake()->dateTimeBetween('-7 months', 'now'),
            'sender' => fake()->randomElement($senders),
            'subject' => fake()->randomElement($subjects),
            'has_attachment' => fake()->boolean(30),
            'file' => null,
        ];
    }
}
