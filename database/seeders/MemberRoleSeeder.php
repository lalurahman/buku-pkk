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
            ['name' => 'Sekretaris'],
            ['name' => 'Bendahara'],
            ['name' => 'Anggota'],
        ];

        foreach ($memberRoles as $role) {
            MemberRole::create($role);
        }
    }
}
