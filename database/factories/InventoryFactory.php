<?php

namespace Database\Factories;

use App\Models\Inventory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Inventory>
 */
class InventoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $items = [
            'Meja',
            'Kursi',
            'Lemari',
            'Komputer',
            'Printer',
            'Timbangan Bayi',
            'Alat Pengukur Tinggi Badan',
            'Peralatan Posyandu',
            'Papan Tulis',
            'LCD Proyektor',
            'Sound System',
            'Tenda',
            'Karpet',
            'Dispenser',
            'Kulkas',
        ];

        $sources = [
            'Pembelian',
            'Hibah Pemerintah',
            'Sumbangan',
            'Bantuan CSR',
            'APBD',
            'Dana Desa',
            'Swadaya Masyarakat',
        ];

        $locations = [
            'Kantor Sekretariat',
            'Gudang Utama',
            'Posyandu Melati 1',
            'Posyandu Melati 2',
            'Posyandu Mawar',
            'Balai RW 01',
            'Balai RW 02',
            'Aula Kelurahan',
        ];

        $conditions = [
            'Baik',
            'Rusak Ringan',
            'Rusak Berat',
        ];

        return [
            'name' => fake()->randomElement($items),
            'source' => fake()->randomElement($sources),
            'received_date' => fake()->dateTimeBetween('-3 years', 'now'),
            'purchase_date' => fake()->dateTimeBetween('-3 years', 'now'),
            'quantity' => fake()->numberBetween(1, 50),
            'storage_location' => fake()->randomElement($locations),
            'condition' => fake()->randomElement($conditions),
        ];
    }
}
