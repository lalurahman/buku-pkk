<?php

namespace Database\Seeders;

use App\Models\SourceFund;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SourceFundSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sourceFunds = [
            ['name' => 'APBD'],
            ['name' => 'Swadaya Masyarakat'],
            ['name' => 'Donasi'],
        ];

        foreach ($sourceFunds as $fund) {
            SourceFund::create($fund);
        }
    }
}
