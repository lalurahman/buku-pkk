<?php

namespace App\Http\Controllers\District;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\District;
use App\Models\UserHasDistrict;
use App\Models\Village;
use App\Models\VillageActivity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get district_id dari user yang login
        $userHasDistrict = UserHasDistrict::where('user_id', Auth::id())->first();
        $districtId = $userHasDistrict ? $userHasDistrict->district_id : null;

        // Get district info
        $district = District::with('regency')->find($districtId);

        // Total desa di kecamatan ini
        $totalVillages = Village::where('district_id', $districtId)->count();

        // Total kegiatan yang diikuti desa di kecamatan ini
        $totalActivities = Activity::whereHas('subActivities.villageActivities.village', function ($query) use ($districtId) {
            $query->where('district_id', $districtId);
        })->count();

        // Total village activities
        $totalVillageActivities = VillageActivity::whereHas('village', function ($query) use ($districtId) {
            $query->where('district_id', $districtId);
        })->count();

        // Completed activities
        $completedActivities = VillageActivity::whereHas('village', function ($query) use ($districtId) {
            $query->where('district_id', $districtId);
        })->where('status', 'completed')->count();

        // Pending activities
        $pendingActivities = VillageActivity::whereHas('village', function ($query) use ($districtId) {
            $query->where('district_id', $districtId);
        })->where('status', 'pending')->count();

        // In progress activities
        $inProgressActivities = VillageActivity::whereHas('village', function ($query) use ($districtId) {
            $query->where('district_id', $districtId);
        })->where('status', 'in_progress')->count();

        // Overall progress percentage
        $overallProgress = $totalVillageActivities > 0
            ? round(($completedActivities / $totalVillageActivities) * 100, 1)
            : 0;

        // Get activities with progress for chart
        $activitiesProgress = Activity::whereHas('subActivities.villageActivities.village', function ($query) use ($districtId) {
            $query->where('district_id', $districtId);
        })
            ->withCount([
                'subActivities as total_sub_activities',
            ])
            ->with(['subActivities' => function ($query) use ($districtId) {
                $query->withCount([
                    'villageActivities as total_village_activities' => function ($q) use ($districtId) {
                        $q->whereHas('village', function ($vq) use ($districtId) {
                            $vq->where('district_id', $districtId);
                        });
                    },
                    'villageActivities as completed_village_activities' => function ($q) use ($districtId) {
                        $q->whereHas('village', function ($vq) use ($districtId) {
                            $vq->where('district_id', $districtId);
                        })->where('status', 'completed');
                    },
                ]);
            }])
            ->limit(10)
            ->get()
            ->map(function ($activity) {
                $totalActivities = $activity->subActivities->sum('total_village_activities');
                $completedActivities = $activity->subActivities->sum('completed_village_activities');

                return [
                    'name' => $activity->title,
                    'total' => $totalActivities,
                    'completed' => $completedActivities,
                    'progress' => $totalActivities > 0 ? round(($completedActivities / $totalActivities) * 100, 1) : 0,
                ];
            });

        // Top 5 villages by completion
        $topVillages = Village::where('district_id', $districtId)
            ->withCount([
                'villageActivities as total_activities',
                'villageActivities as completed_activities' => function ($q) {
                    $q->where('status', 'completed');
                }
            ])
            ->having('total_activities', '>', 0)
            ->orderByDesc('completed_activities')
            ->limit(5)
            ->get()
            ->map(function ($village) {
                return [
                    'name' => $village->name,
                    'total' => $village->total_activities,
                    'completed' => $village->completed_activities,
                    'progress' => $village->total_activities > 0
                        ? round(($village->completed_activities / $village->total_activities) * 100, 1)
                        : 0,
                ];
            });

        return view('pages.district.dashboard.index', compact(
            'district',
            'totalVillages',
            'totalActivities',
            'totalVillageActivities',
            'completedActivities',
            'pendingActivities',
            'inProgressActivities',
            'overallProgress',
            'activitiesProgress',
            'topVillages'
        ));
    }
}
