<?php

namespace Database\Factories;

use App\Models\SourceFund;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SourceFund>
 */
class SourceFundFactory extends Factory
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
                'APBD',
                'APBN',
                'Dana Desa',
                'Swadaya Masyarakat',
                'Donasi',
                'Iuran Anggota',
                'Dana CSR',
                'Bantuan Pemerintah',
            ]),
        ];
    }
}
