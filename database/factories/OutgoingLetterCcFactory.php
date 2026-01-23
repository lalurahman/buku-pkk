<?php

namespace Database\Factories;

use App\Models\OutgoingLetterCc;
use App\Models\OutgoingLetter;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OutgoingLetterCc>
 */
class OutgoingLetterCcFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $ccRecipients = [
            'Ketua TP PKK Kecamatan',
            'Sekretaris TP PKK',
            'Bendahara TP PKK',
            'Koordinator Pokja 1',
            'Koordinator Pokja 2',
            'Koordinator Pokja 3',
            'Koordinator Pokja 4',
            'Camat',
            'Lurah/Kepala Desa',
            'Ketua RT/RW',
            'Arsip',
        ];

        return [
            'outgoing_letter_id' => OutgoingLetter::inRandomOrder()->first()?->id ?? OutgoingLetter::factory(),
            'cc_recipient' => fake()->randomElement($ccRecipients),
        ];
    }
}
