<?php

namespace Database\Seeders;

use App\Models\FunctionalPosition;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FunctionalPositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $functionalPositions = [
            ['name' => 'TP PKK'],
            ['name' => 'Kader Umum'],
            ['name' => 'Kader Khusus'],
        ];

        foreach ($functionalPositions as $position) {
            FunctionalPosition::create($position);
        }
    }
}
