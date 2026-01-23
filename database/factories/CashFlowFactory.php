<?php

namespace Database\Factories;

use App\Models\CashFlow;
use App\Models\SourceFund;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CashFlow>
 */
class CashFlowFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // 70% income, 30% expense
        $type = fake()->randomFloat(0, 0, 100) <= 70 ? 'income' : 'expense';

        $incomeDescriptions = [
            'Iuran bulanan anggota',
            'Donasi dari masyarakat',
            'Bantuan dana pemerintah',
            'Hasil usaha PKK',
            'Sumbangan perusahaan',
            'Dana CSR',
            'Hasil kegiatan bazaar',
        ];

        $expenseDescriptions = [
            'Pembelian bahan kegiatan',
            'Biaya transportasi',
            'Konsumsi rapat',
            'ATK dan perlengkapan',
            'Biaya operasional',
            'Pembelian peralatan',
            'Biaya kegiatan posyandu',
            'Biaya pelatihan',
        ];

        return [
            'type' => $type,
            'source_fund_id' => SourceFund::inRandomOrder()->first()?->id ?? SourceFund::factory(),
            'receipt_number' => fake()->unique()->numerify('KW-###/PKK/####'),
            'date' => fake()->dateTimeBetween('-1 year', 'now'),
            'amount' => fake()->randomFloat(2, 50000, 10000000),
            'description' => $type === 'income'
                ? fake()->randomElement($incomeDescriptions)
                : fake()->randomElement($expenseDescriptions),
        ];
    }
}
