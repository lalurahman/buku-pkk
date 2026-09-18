<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Corrects district (kecamatan) and village (desa/kelurahan) names for
 * Kabupaten Takalar (regency_id 7305).
 *
 * The azishapidin/indoregion package (vendor/azishapidin/indoregion) has not
 * been updated since 2018 and ships several villages with typos or outdated
 * spelling for Kabupaten Takalar. This seeder patches only those records to
 * match the current official region codes from Kemendagri
 * (Kepmendagri No. 300.2.2-2430 Tahun 2025, via https://github.com/cahyadsn/wilayah),
 * without touching any other regency.
 *
 * @see IndoRegionSeeder Must run first so the rows this seeder updates exist.
 */
class TakalarRegionSeeder extends Seeder
{
    /**
     * Village id => corrected name, keyed by the id already seeded by
     * IndoRegionVillageSeeder so no ids or relations change.
     */
    private const VILLAGE_NAME_FIXES = [
        '7305020003' => "Takalar",
        '7305020006' => "Pa'batangang",
        '7305031006' => "Somba Bella",
        '7305040002' => "Manongkoki",
        '7305040005' => "Mattompodale",
        '7305040025' => "Kale Ko'mara",
        '7305040027' => "Parang Baddo",
        '7305050003' => "Barangmamase",
        '7305060012' => "Kaballokang Pakkabba",
    ];

    public function run(): void
    {
        foreach (self::VILLAGE_NAME_FIXES as $villageId => $name) {
            DB::table('villages')
                ->where('id', $villageId)
                ->where('district_id', 'like', '7305%')
                ->update(['name' => $name]);
        }
    }
}
