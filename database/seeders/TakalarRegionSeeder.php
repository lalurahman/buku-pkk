<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Brings Kabupaten Takalar (regency_id 7305) region data in line with the
 * current official Kemendagri region codes (Kepmendagri No. 300.2.2-2430
 * Tahun 2025, via https://github.com/cahyadsn/wilayah).
 *
 * The azishapidin/indoregion package this app seeds from has not been
 * updated since 2018, so it predates three kecamatan splits that already
 * happened in Takalar (Laikang split from Mangarabombang, Kepulauan
 * Tanakeke split from Mappakasunggu, Polongbangkeng Timur split from
 * Polongbangkeng Utara). As a result, on top of a stock IndoRegionSeeder
 * run, Takalar's data is missing all 3 of those kecamatan and has several
 * villages parked under their old pre-split kecamatan with outdated
 * spelling.
 *
 * This seeder patches only Kabupaten Takalar, without touching any other
 * regency, and is safe to re-run: districts are upserted by id, existing
 * villages are relocated/renamed by their existing id (so nothing that
 * already references a village id, e.g. user_has_villages, is broken),
 * and villages that never existed at all are inserted with a fresh id
 * that keeps the "district_id + 3 digit sequence" convention already used
 * by the rest of the villages table.
 *
 * @see IndoRegionSeeder Must run first so the rows this seeder touches exist.
 */
class TakalarRegionSeeder extends Seeder
{
    private const REGENCY_ID = '7305';

    /**
     * Kecamatan that don't exist yet because they were split off after the
     * upstream package's last data update.
     */
    private const NEW_DISTRICTS = [
        '7305041' => 'Polongbangkeng Timur',
        '7305061' => 'Kepulauan Tanakeke',
        '7305062' => 'Laikang',
    ];

    /**
     * Existing village id => [correct district_id, correct name].
     * Covers both villages that only need a spelling fix and villages that
     * need to move to one of the new kecamatan above.
     */
    private const VILLAGE_FIXES = [
        '7305010001' => ['7305062', "Punaga"],
        '7305010002' => ['7305062', "Laikang"],
        '7305010003' => ['7305062', "Cikoang"],
        '7305010004' => ['7305062', "Pattopakang"],
        '7305010005' => ['7305062', "Bontoparang"],
        '7305010006' => ['7305062', "Panyangkalang"],
        '7305010007' => ['7305010', "Bontomanai"],
        '7305010008' => ['7305010', "Lakatong"],
        '7305010009' => ['7305010', "Topejawa"],
        '7305010010' => ['7305010', "Banggae"],
        '7305010011' => ['7305010', "Mangadu"],
        '7305020001' => ['7305061', "Mattiro Baji"],
        '7305020002' => ['7305061', "Maccini Baji"],
        '7305020004' => ['7305020', "Patani"],
        '7305020005' => ['7305020', "Soreang"],
        '7305020007' => ['7305061', "Rewataya"],
        '7305020008' => ['7305061', "Tompotana"],
        '7305020009' => ['7305061', "Balangdatu"],
        '7305021001' => ['7305021', "Laguruda"],
        '7305021002' => ['7305021', "Sanrobone"],
        '7305021003' => ['7305021', "Banyuanyara"],
        '7305021004' => ['7305021', "Paddinging"],
        '7305021005' => ['7305021', "Ujung Baji"],
        '7305021006' => ['7305021', "Tonasa"],
        '7305030003' => ['7305030', "Pa'bundukang"],
        '7305030005' => ['7305030', "Canrego"],
        '7305030006' => ['7305030', "Bontokadatto"],
        '7305030007' => ['7305030', "Bulukunyi"],
        '7305030008' => ['7305030', "Cakura"],
        '7305030009' => ['7305030', "Lantang"],
        '7305030010' => ['7305030', "Moncongkomba"],
        '7305030011' => ['7305030', "Pattene"],
        '7305030012' => ['7305030', "Rajaya"],
        '7305030013' => ['7305030', "Su'rulangi"],
        '7305031001' => ['7305031', "Pattallassang"],
        '7305031002' => ['7305031', "Pallantikang"],
        '7305031003' => ['7305031', "Pappa"],
        '7305031004' => ['7305031', "Maradekaya"],
        '7305031005' => ['7305031', "Kalabbirang"],
        '7305031007' => ['7305031', "Bajeng"],
        '7305031008' => ['7305031', "Sabintang"],
        '7305031009' => ['7305031', "Salaka"],
        '7305040003' => ['7305040', "Panrannuangku"],
        '7305040004' => ['7305040', "Manongkoki"],
        '7305040006' => ['7305040', "Palleko"],
        '7305040008' => ['7305040', "Parang Luara"],
        '7305040009' => ['7305040', "Pa'rappunganta"],
        '7305040010' => ['7305041', "Massamaturu"],
        '7305040011' => ['7305041', "Timbuseng"],
        '7305040012' => ['7305041', "Ko'mara"],
        '7305040013' => ['7305041', "Barugaya"],
        '7305040014' => ['7305040', "Towata"],
        '7305040015' => ['7305041', "Kampung Beru"],
        '7305040016' => ['7305040', "Lassang"],
        '7305040017' => ['7305041', "Parang Baddo"],
        '7305040018' => ['7305040', "Lassang Barat"],
        '7305040019' => ['7305041', "Balangtanaya"],
        '7305040020' => ['7305041', "Kale Ko'mara"],
        '7305050001' => ['7305050', "Mangindara"],
        '7305050002' => ['7305050', "Bontomarannu"],
        '7305050004' => ['7305050', "Bontokassi"],
        '7305050005' => ['7305050', "Sawakong"],
        '7305050006' => ['7305050', "Bentang"],
        '7305050007' => ['7305050', "Bonto Kanang"],
        '7305050015' => ['7305050', "Popo"],
        '7305050016' => ['7305050', "Tarowang"],
        '7305050017' => ['7305050', "Kadatong"],
        '7305050018' => ['7305050', "Kale Bentang"],
        '7305050019' => ['7305050', "Kalukubodo"],
        '7305051001' => ['7305051', "Bontoloe"],
        '7305051002' => ['7305051', "Kalenna Bontongape"],
        '7305051003' => ['7305051', "Bontomangape"],
        '7305051004' => ['7305051', "Parambambe"],
        '7305051005' => ['7305051', "Pattinoang"],
        '7305051006' => ['7305051', "Boddia"],
        '7305051007' => ['7305051', "Parangmata"],
        '7305051008' => ['7305051', "Galesong Kota"],
        '7305051009' => ['7305051', "Galesong Baru"],
        '7305051010' => ['7305051', "Pa'lalakkang"],
        '7305051011' => ['7305051', "Pa'rasangang Beru"],
        '7305051012' => ['7305051', "Kalukuang"],
        '7305051013' => ['7305051', "Mappakalompo"],
        '7305051014' => ['7305051', "Campagaya"],
        '7305060003' => ['7305060', "Bontosunggu"],
        '7305060004' => ['7305060', "Tamasaju"],
        '7305060005' => ['7305060', "Bontolebang"],
        '7305060006' => ['7305060', "Tamalate"],
        '7305060007' => ['7305060', "Aeng Batu Batu"],
        '7305060008' => ['7305060', "Bontolanra"],
        '7305060009' => ['7305060', "Pakkabba"],
        '7305060010' => ['7305060', "Aeng Towa"],
        '7305060011' => ['7305060', "Sampulungan"],
    ];

    /**
     * Villages that don't exist under any id yet (verified against
     * production: no name in this list has a near-duplicate anywhere in
     * Takalar's existing rows). New ids keep the district_id + 3 digit
     * sequence convention, continuing past the highest sequence already
     * used in that district.
     */
    private const NEW_VILLAGES = [
        '7305010012' => ['7305010', "Lengkese"],
        '7305030014' => ['7305030', "Kale Lantang"],
        '7305040021' => ['7305040', "Malewang"],
        '7305050020' => ['7305050', "Kanaeng"],
        '7305060013' => ['7305060', "Bontokaddopepe"],
        '7305060014' => ['7305060', "Maccini Sombala"],
        '7305060015' => ['7305060', "Sawakung Beba"],
        '7305060016' => ['7305060', "Biring Kassi"],
        '7305051015' => ['7305051', "Galesong Timur"],
        '7305051016' => ['7305051', "Kampung Beru"],
        '7305051017' => ['7305051', "Tarembang"],
        '7305061001' => ['7305061', "Minasa Baji"],
    ];

    public function run(): void
    {
        DB::transaction(function () {
            foreach (self::NEW_DISTRICTS as $id => $name) {
                DB::table('districts')->updateOrInsert(
                    ['id' => $id],
                    ['regency_id' => self::REGENCY_ID, 'name' => $name]
                );
            }

            foreach (self::VILLAGE_FIXES as $id => [$districtId, $name]) {
                DB::table('villages')
                    ->where('id', $id)
                    ->update(['district_id' => $districtId, 'name' => $name]);
            }

            foreach (self::NEW_VILLAGES as $id => [$districtId, $name]) {
                DB::table('villages')->updateOrInsert(
                    ['id' => $id],
                    ['district_id' => $districtId, 'name' => $name]
                );
            }
        });
    }
}
