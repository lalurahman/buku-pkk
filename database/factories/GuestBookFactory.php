<?php

namespace Database\Factories;

use App\Models\GuestBook;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GuestBook>
 */
class GuestBookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $institutions = [
            'Dinas Pemberdayaan Masyarakat',
            'Kecamatan',
            'Kelurahan',
            'TP PKK Kabupaten',
            'TP PKK Provinsi',
            'Puskesmas',
            'BKKBN',
            'Dinas Kesehatan',
            'Dinas Sosial',
            'Universitas',
            'LSM',
            'Media Massa',
        ];

        $purposes = [
            'Studi Banding',
            'Pembinaan',
            'Monitoring dan Evaluasi',
            'Kunjungan Kerja',
            'Sosialisasi Program',
            'Koordinasi Kegiatan',
            'Penelitian',
            'Wawancara',
            'Dokumentasi',
            'Silaturahmi',
        ];

        $impressions = [
            'Sangat baik dan terorganisir dengan baik',
            'Kegiatan berjalan lancar dan bermanfaat',
            'Pelayanan ramah dan profesional',
            'Dokumentasi lengkap dan rapi',
            'Pengurus sangat kooperatif',
            'Fasilitas memadai dan bersih',
            'Program kerja terstruktur dengan baik',
            'Semoga kedepannya lebih baik lagi',
        ];

        return [
            'visitor_name' => fake()->name(),
            'visit_date' => fake()->dateTimeBetween('-1 year', 'now'),
            'institution' => fake()->randomElement($institutions),
            'purpose' => fake()->randomElement($purposes),
            'impressions' => fake()->randomElement($impressions),
        ];
    }
}
