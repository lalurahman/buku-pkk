<?php

namespace App\Http\Controllers\District;

use App\DataTables\District\VillageDataTable;
use App\Http\Controllers\Controller;
use App\Models\Village;
use Illuminate\Http\Request;

class VillageController extends Controller
{
    /**
     * Display a listing of the villages.
     */
    public function index(VillageDataTable $dataTable)
    {
        return $dataTable->render('pages.district.village.index');
    }

    /**
     * Display the specified village.
     */
    public function show(Village $village)
    {
        $village->load(['district.regency', 'villageActivities.subActivity.activity']);

        // Group village activities by activity
        $groupedActivities = $village->villageActivities()
            ->with(['subActivity.activity', 'galleryVillageActivities'])
            ->get()
            ->groupBy(function ($item) {
                return $item->subActivity->activity->name;
            });

        return view('pages.district.village.show', compact('village', 'groupedActivities'));
    }
}
