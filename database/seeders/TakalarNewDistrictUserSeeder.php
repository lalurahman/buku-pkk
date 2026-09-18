<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\User;
use App\Models\UserHasDistrict;
use App\Models\UserHasVillage;
use App\Models\Village;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Creates the kecamatan and desa/kelurahan login accounts for the 3
 * kecamatan added by TakalarRegionSeeder (Polongbangkeng Timur, Kepulauan
 * Tanakeke, Laikang), following the exact same account pattern UserSeeder
 * used for the original 9 kecamatan: one "District"-role account per
 * kecamatan and one "Village"-role account per desa/kelurahan, with the
 * same email and password conventions.
 *
 * Safe to re-run: every account is only created if a district/village
 * doesn't already have one.
 *
 * @see TakalarRegionSeeder Must run first so these districts/villages exist.
 */
class TakalarNewDistrictUserSeeder extends Seeder
{
    private const NEW_DISTRICT_IDS = ['7305041', '7305061', '7305062'];

    public function run(): void
    {
        $districts = District::whereIn('id', self::NEW_DISTRICT_IDS)->get();

        foreach ($districts as $district) {
            if (!UserHasDistrict::where('district_id', $district->id)->exists()) {
                $userKecamatan = User::create([
                    'name' => 'Kecamatan ' . $district->name,
                    'email' => 'kecamatan.' . strtolower(str_replace(' ', '', $district->name)) . '@gmail.com',
                    'password' => Hash::make('1234567890'),
                ]);

                $userKecamatan->assignRole('District');

                UserHasDistrict::create([
                    'user_id' => $userKecamatan->id,
                    'district_id' => $district->id,
                ]);
            }

            $villages = Village::where('district_id', $district->id)->get();

            foreach ($villages as $village) {
                if (UserHasVillage::where('village_id', $village->id)->exists()) {
                    continue;
                }

                $baseEmail = strtolower(str_replace(' ', '', $village->name));
                $email = $baseEmail . '@gmail.com';
                $counter = 1;

                while (User::where('email', $email)->exists()) {
                    $email = $baseEmail . $counter . '@gmail.com';
                    $counter++;
                }

                $userDesa = User::create([
                    'name' => $village->name,
                    'email' => $email,
                    'password' => Hash::make('1234567890'),
                ]);

                $userDesa->assignRole('Village');

                UserHasVillage::create([
                    'user_id' => $userDesa->id,
                    'village_id' => $village->id,
                ]);
            }
        }
    }
}
