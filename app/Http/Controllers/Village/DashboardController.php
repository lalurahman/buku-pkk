<?php

namespace App\Http\Controllers\Village;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\UserHasVillage;
use App\Models\Village;
use App\Models\VillageActivity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get village_id dari user yang login
        $userHasVillage = UserHasVillage::where('user_id', Auth::id())->first();
        $villageId = $userHasVillage ? $userHasVillage->village_id : null;

        // Get village info
        $village = Village::with('district.regency')->find($villageId);

        // Total village activities
        $totalActivities = VillageActivity::where('village_id', $villageId)->count();

        // Completed activities
        $completedActivities = VillageActivity::where('village_id', $villageId)
            ->where('status', 'completed')->count();

        // Unfinished activities (pending + in_progress)
        $unfinishedActivities = $totalActivities - $completedActivities;

        // Pending activities
        $pendingActivities = VillageActivity::where('village_id', $villageId)
            ->where('status', 'pending')->count();

        // In progress activities
        $inProgressActivities = VillageActivity::where('village_id', $villageId)
            ->where('status', 'in_progress')->count();

        // Overall progress percentage
        $overallProgress = $totalActivities > 0
            ? round(($completedActivities / $totalActivities) * 100, 1)
            : 0;

        // Get activities with progress for chart (group by main activity)
        $activitiesProgress = Activity::whereHas('subActivities.villageActivities', function ($query) use ($villageId) {
            $query->where('village_id', $villageId);
        })
            ->with(['subActivities' => function ($query) use ($villageId) {
                $query->withCount([
                    'villageActivities as total_village_activities' => function ($q) use ($villageId) {
                        $q->where('village_id', $villageId);
                    },
                    'villageActivities as completed_village_activities' => function ($q) use ($villageId) {
                        $q->where('village_id', $villageId)->where('status', 'completed');
                    },
                ]);
            }])
            ->get()
            ->map(function ($activity) {
                $totalActivities = $activity->subActivities->sum('total_village_activities');
                $completedActivities = $activity->subActivities->sum('completed_village_activities');

                return [
                    'name' => $activity->title,
                    'total' => $totalActivities,
                    'completed' => $completedActivities,
                    'pending' => $totalActivities - $completedActivities,
                    'progress' => $totalActivities > 0 ? round(($completedActivities / $totalActivities) * 100, 1) : 0,
                ];
            });

        // Recent activities with details
        $recentActivities = VillageActivity::where('village_id', $villageId)
            ->with(['subActivity.activity', 'galleryVillageActivities'])
            ->orderBy('updated_at', 'desc')
            ->limit(5)
            ->get();

        // Status distribution for pie chart
        $statusDistribution = [
            'completed' => $completedActivities,
            'in_progress' => $inProgressActivities,
            'pending' => $pendingActivities,
        ];

        return view('pages.village.dashboard.index', compact(
            'village',
            'totalActivities',
            'completedActivities',
            'unfinishedActivities',
            'pendingActivities',
            'inProgressActivities',
            'overallProgress',
            'activitiesProgress',
            'recentActivities',
            'statusDistribution'
        ));
    }
}
