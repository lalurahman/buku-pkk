<?php

namespace Database\Factories;

use App\Models\LetterDisposition;
use App\Models\IncomingLetter;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LetterDisposition>
 */
class LetterDispositionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $dispositionTos = [
            'Sekretaris',
            'Bendahara',
            'Koordinator Pokja 1',
            'Koordinator Pokja 2',
            'Koordinator Pokja 3',
            'Koordinator Pokja 4',
            'Seluruh Anggota',
            'Tim Pokja 1',
            'Tim Pokja 2',
            'Ketua Dasawisma',
        ];

        $instructions = [
            'Mohon ditindaklanjuti sesuai bidang',
            'Untuk diketahui dan dilaksanakan',
            'Harap dikoordinasikan dengan anggota',
            'Mohon segera ditanggapi',
            'Untuk dibahas dalam rapat koordinasi',
            'Harap dilaporkan hasilnya',
            'Mohon disiapkan keperluan acara',
            'Untuk ditindaklanjuti sesuai prosedur',
        ];

        return [
            'incoming_letter_id' => IncomingLetter::inRandomOrder()->first()?->id ?? IncomingLetter::factory(),
            'disposition_to' => fake()->randomElement($dispositionTos),
            'instructions' => fake()->randomElement($instructions),
            'disposition_date' => fake()->dateTimeBetween('-6 months', 'now'),
            'from' => 'Ketua TP PKK',
            'priority' => fake()->randomElement(['normal', 'important', 'urgent']),
        ];
    }
}
