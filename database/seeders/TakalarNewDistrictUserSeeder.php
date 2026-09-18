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
 * Creates login accounts for Kabupaten Takalar (regency_id 7305) region
 * data that TakalarRegionSeeder added but has no account yet: the 3 new
 * kecamatan (Polongbangkeng Timur, Kepulauan Tanakeke, Laikang) and every
 * desa/kelurahan across all of Takalar that isn't already covered by an
 * account, whether it's under one of those 3 new kecamatan or was newly
 * inserted under an existing one (e.g. Lengkese under Mangarabombang).
 *
 * Follows the exact same account pattern UserSeeder used for the original
 * 9 kecamatan / 99 desa: one "District"-role account per kecamatan and one
 * "Village"-role account per desa/kelurahan, with the same email and
 * password conventions.
 *
 * Safe to re-run: every account is only created if the district/village
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
            if (UserHasDistrict::where('district_id', $district->id)->exists()) {
                continue;
            }

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

        $villagesWithoutAccount = Village::where('district_id', 'like', '7305%')
            ->whereNotIn('id', UserHasVillage::pluck('village_id'))
            ->get();

        foreach ($villagesWithoutAccount as $village) {
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
