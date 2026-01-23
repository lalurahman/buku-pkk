<?php

namespace Database\Factories;

use App\Models\OutgoingLetter;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OutgoingLetter>
 */
class OutgoingLetterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subjects = [
            'Undangan Rapat Anggota',
            'Permohonan Bantuan Kegiatan',
            'Laporan Pertanggungjawaban',
            'Pemberitahuan Pelaksanaan Program',
            'Surat Balasan Permohonan',
            'Pengajuan Proposal Kegiatan',
            'Surat Tugas Kader',
            'Pemberitahuan Jadwal Kegiatan',
            'Permohonan Izin Penggunaan Tempat',
            'Surat Keterangan Kegiatan',
        ];

        $recipients = [
            'Kepala Dinas Pemberdayaan Masyarakat',
            'Camat',
            'Lurah/Kepala Desa',
            'Ketua TP PKK Kabupaten',
            'Ketua TP PKK Provinsi',
            'Kepala Puskesmas',
            'Ketua RT/RW',
            'Seluruh Anggota PKK',
            'Kepala Sekolah',
            'Ketua Dasawisma',
        ];

        return [
            'letter_number' => fake()->unique()->numerify('###/SK/PKK/####'),
            'letter_date' => fake()->dateTimeBetween('-6 months', 'now'),
            'recipient' => fake()->randomElement($recipients),
            'subject' => fake()->randomElement($subjects),
            'has_attachment' => fake()->boolean(25),
            'file' => null,
        ];
    }
}
