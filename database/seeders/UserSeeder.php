<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\District;
use App\Models\Village;
use App\Models\UserHasDistrict;
use App\Models\UserHasVillage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Superadmin',
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('password123'),
        ]);

        $user->assignRole('Superadmin');

        // create user admin
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password123'),
        ]);


        $admin->assignRole('Admin');

        // user kecamatan 7305 : kecamatan dari kabupaten takalar
        $districts = District::where('regency_id', 7305)->get();

        foreach ($districts as $district) {
            $userKecamatan = User::create([
                'name' => 'Kecamatan ' . $district->name,
                'email' => 'kecamatan.' . strtolower(str_replace(' ', '', $district->name)) . '@gmail.com',
                'password' => Hash::make('password123'),
            ]);

            $userKecamatan->assignRole('District');

            // Tambahkan ke user_has_districts
            UserHasDistrict::create([
                'user_id' => $userKecamatan->id,
                'district_id' => $district->id,
            ]);

            // get semua desa dari kecamatan ini
            $villages = Village::where('district_id', $district->id)->get();

            foreach ($villages as $village) {
                // Generate email unik
                $baseEmail = 'desa.' . strtolower(str_replace(' ', '', $village->name));
                $email = $baseEmail . '@gmail.com';
                $counter = 1;

                // Cek jika email sudah ada, tambahkan angka di belakang
                while (User::where('email', $email)->exists()) {
                    $email = $baseEmail . $counter . '@gmail.com';
                    $counter++;
                }

                $userDesa = User::create([
                    'name' => 'Desa ' . $village->name,
                    'email' => $email,
                    'password' => Hash::make('password123'),
                ]);

                $userDesa->assignRole('Village');

                // Tambahkan ke user_has_villages
                UserHasVillage::create([
                    'user_id' => $userDesa->id,
                    'village_id' => $village->id,
                ]);
            }
        }
    }
}
