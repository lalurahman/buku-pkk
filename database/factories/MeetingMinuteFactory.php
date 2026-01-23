<?php

namespace Database\Factories;

use App\Models\MeetingMinute;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MeetingMinute>
 */
class MeetingMinuteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $locations = [
            'Kantor Sekretariat PKK',
            'Balai RW 01',
            'Balai RW 02',
            'Aula Kelurahan',
            'Gedung Serbaguna',
            'Rumah Ketua PKK',
        ];

        $meetingTypes = [
            'Rapat Rutin Bulanan',
            'Rapat Koordinasi',
            'Rapat Evaluasi Program',
            'Rapat Pembahasan Kegiatan',
            'Rapat Pengurus',
            'Rapat Pleno',
            'Rapat Kerja',
        ];

        $leaders = [
            'Ketua TP PKK',
            'Wakil Ketua TP PKK',
            'Sekretaris',
            'Koordinator Pokja 1',
            'Koordinator Pokja 2',
        ];

        $agendas = [
            'Pembahasan program kerja triwulan',
            'Evaluasi kegiatan bulan lalu',
            'Perencanaan kegiatan posyandu',
            'Pembahasan anggaran kegiatan',
            'Persiapan lomba PKK',
            'Koordinasi dengan kelurahan',
            'Pembentukan tim kerja',
        ];

        return [
            'meeting_date' => fake()->dateTimeBetween('-1 year', 'now'),
            'location' => fake()->randomElement($locations),
            'start_time' => fake()->time('H:i:s', '14:00:00'),
            'end_time' => fake()->time('H:i:s', '17:00:00'),
            'meeting_type' => fake()->randomElement($meetingTypes),
            'leader' => fake()->randomElement($leaders),
            'invited_count' => fake()->numberBetween(10, 50),
            'attended_count' => fake()->numberBetween(8, 45),
            'agenda' => fake()->randomElement($agendas),
            'discussion' => fake()->paragraph(4),
            'conclusion' => fake()->paragraph(2),
            'follow_up' => fake()->paragraph(2),
        ];
    }
}
