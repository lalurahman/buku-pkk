<?php

namespace Database\Seeders;

use App\Models\MemberRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MemberRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $memberRoles = [
            ['name' => 'Ketua'],
            ['name' => 'Ketua Bidang 1'],
            ['name' => 'Ketua Bidang 2'],
            ['name' => 'Ketua Bidang 3'],
            ['name' => 'Ketua Bidang 4'],
            ['name' => 'Ketua Pokja 1'],
            ['name' => 'Ketua Pokja 2'],
            ['name' => 'Ketua Pokja 3'],
            ['name' => 'Ketua Pokja 4'],
            ['name' => 'Sekretaris'],
            ['name' => 'Sekretaris Pokja 1'],
            ['name' => 'Sekretaris Pokja 2'],
            ['name' => 'Sekretaris Pokja 3'],
            ['name' => 'Sekretaris Pokja 4'],
            ['name' => 'Bendahara'],
            ['name' => 'Staf Ahli 1'],
            ['name' => 'Staf Ahli 2'],
            ['name' => 'Staf Ahli 3'],
            ['name' => 'Staf Ahli 4'],
            ['name' => 'Anggota'],
        ];

        foreach ($memberRoles as $role) {
            MemberRole::create($role);
        }
    }
}
