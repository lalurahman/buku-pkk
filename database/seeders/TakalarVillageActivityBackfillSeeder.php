<?php

namespace Database\Seeders;

use App\Models\SubActivity;
use App\Models\Village;
use App\Models\VillageActivity;
use Illuminate\Database\Seeder;

/**
 * Backfills village_activities rows for sub-activities that were created
 * before TakalarRegionSeeder completed Kabupaten Takalar's village list.
 *
 * Admin\ActivityController::storeSubActivity() fans a new sub-activity out
 * to every village in regency 7305 at the moment it's created. Any
 * sub-activity created while the villages table was still missing rows
 * never got a village_activities row for the villages added later, so
 * those villages silently have no record of that sub-activity.
 *
 * Safe to re-run: only creates a village_activities row for a
 * (sub_activity, village) pair that doesn't already have one, with the
 * same default status ('pending') storeSubActivity uses.
 *
 * @see TakalarRegionSeeder Must run first so all Takalar villages exist.
 */
class TakalarVillageActivityBackfillSeeder extends Seeder
{
    public function run(): void
    {
        $takalarVillageIds = Village::where('district_id', 'like', '7305%')
            ->pluck('id');

        SubActivity::all()->each(function (SubActivity $subActivity) use ($takalarVillageIds) {
            $existingVillageIds = VillageActivity::where('sub_activity_id', $subActivity->id)
                ->pluck('village_id');

            $missingVillageIds = $takalarVillageIds->diff($existingVillageIds);

            foreach ($missingVillageIds as $villageId) {
                VillageActivity::create([
                    'village_id' => $villageId,
                    'sub_activity_id' => $subActivity->id,
                    'status' => 'pending',
                ]);
            }
        });
    }
}
