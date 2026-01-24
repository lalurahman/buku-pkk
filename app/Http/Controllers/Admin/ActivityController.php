<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\ActivityDataTable;
use App\DataTables\Admin\ProgressDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\ActivityRequest;
use App\Models\SubActivity;
use App\Models\TargetActivity;
use App\Models\InnovationActivity;
use App\Models\ImpactActivity;
use App\Models\Village;
use App\Models\VillageActivity;
use App\Services\ActivityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    protected $activityService;

    public function __construct(ActivityService $activityService)
    {
        $this->activityService = $activityService;
    }

    private function user()
    {
        return Auth::user();
    }
    /**
     * Display a listing of the resource.
     */
    public function index(ActivityDataTable $dataTable)
    {
        return $dataTable->render('pages.admin.activity.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.activity.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ActivityRequest $request)
    {
        try {
            $data = $request->validated();
            $activity = $this->activityService->createActivity($data);

            // Log activity
            $this->activityService->log(
                $this->user()->getRoleNames()->first(),
                $this->user()->id,
                'created',
                'Menambahkan kegiatan baru: ' . $activity->title
            );

            return redirect()->route('admin.activities.index')
                ->with('success', 'Data kegiatan berhasil ditambahkan');
        } catch (\Throwable $th) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $th->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $activity = $this->activityService->getActivityById($id);

        if (!$activity) {
            return redirect()->route('admin.activities.index')
                ->with('error', 'Data kegiatan tidak ditemukan');
        }

        return view('pages.admin.activity.show', compact('activity'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $activity = $this->activityService->getActivityById($id);

        if (!$activity) {
            return redirect()->route('admin.activities.index')
                ->with('error', 'Data kegiatan tidak ditemukan');
        }

        return view('pages.admin.activity.edit', compact('activity'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ActivityRequest $request, string $id)
    {
        try {
            $activity = $this->activityService->getActivityById($id);

            if (!$activity) {
                return redirect()->route('admin.activities.index')
                    ->with('error', 'Data kegiatan tidak ditemukan');
            }

            $data = $request->validated();
            $this->activityService->updateActivity($activity, $data);

            // Log activity
            $this->activityService->log(
                $this->user()->getRoleNames()->first(),
                $this->user()->id,
                'updated',
                'Memperbarui kegiatan: ' . $activity->title
            );

            return redirect()->route('admin.activities.show', $activity->id)
                ->with('success', 'Data kegiatan berhasil diperbarui');
        } catch (\Throwable $th) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $th->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $activity = $this->activityService->getActivityById($id);

            if (!$activity) {
                return redirect()->route('admin.activities.index')
                    ->with('error', 'Data kegiatan tidak ditemukan');
            }

            // Hitung data yang akan terhapus
            $subActivitiesCount = $activity->subActivities->count();
            $targetActivitiesCount = $activity->targetActivities->count();
            $innovationActivitiesCount = $activity->innovationActivities->count();
            $impactActivitiesCount = $activity->impactActivities->count();

            // Hitung village activities yang akan terhapus
            $villageActivitiesCount = 0;
            foreach ($activity->subActivities as $subActivity) {
                $villageActivitiesCount += $subActivity->villageActivities()->count();
            }

            $activityTitle = $activity->title;

            // Delete activity (cascade akan menghapus semua data terkait)
            $activity->delete();

            // Log activity
            $this->activityService->log(
                $this->user()->getRoleNames()->first(),
                $this->user()->id,
                'deleted',
                'Menghapus kegiatan: ' . $activityTitle
            );

            // Build success message
            $message = 'Kegiatan "' . $activityTitle . '" berhasil dihapus';
            $deletedData = [];

            if ($subActivitiesCount > 0) {
                $deletedData[] = $subActivitiesCount . ' sub kegiatan';
            }
            if ($villageActivitiesCount > 0) {
                $deletedData[] = $villageActivitiesCount . ' data kegiatan desa';
            }
            if ($targetActivitiesCount > 0) {
                $deletedData[] = $targetActivitiesCount . ' target kegiatan';
            }
            if ($innovationActivitiesCount > 0) {
                $deletedData[] = $innovationActivitiesCount . ' inovasi kegiatan';
            }
            if ($impactActivitiesCount > 0) {
                $deletedData[] = $impactActivitiesCount . ' dampak kegiatan';
            }

            if (!empty($deletedData)) {
                $message .= ' beserta ' . implode(', ', $deletedData);
            }

            return redirect()->route('admin.activities.index')->with('success', $message);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Gagal menghapus kegiatan: ' . $th->getMessage());
        }
    }

    // Sub Activity Methods
    public function storeSubActivity(Request $request, $activityId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        try {
            $subActivity = SubActivity::create([
                'activity_id' => $activityId,
                'title' => $request->title,
            ]);

            // Ambil semua village dari kabupaten 7305
            $villages = Village::whereHas('district', function ($query) {
                $query->where('regency_id', '7305');
            })->get();

            // Buat village_activities untuk setiap village
            foreach ($villages as $village) {
                VillageActivity::create([
                    'village_id' => $village->id,
                    'sub_activity_id' => $subActivity->id,
                    'status' => 'pending',
                ]);
            }

            return redirect()->back()->with('success', 'Sub kegiatan berhasil ditambahkan dan didistribusikan ke ' . $villages->count() . ' desa');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Gagal menambahkan sub kegiatan: ' . $th->getMessage());
        }
    }

    public function editSubActivity($activityId, $subActivityId)
    {
        try {
            $activity = $this->activityService->getActivityById($activityId);
            $subActivity = SubActivity::with(['villageActivities.village.district'])->findOrFail($subActivityId);

            if (!$activity) {
                return redirect()->route('admin.activities.index')
                    ->with('error', 'Data kegiatan tidak ditemukan');
            }

            return view('pages.admin.activity.edit_sub_activity', compact('activity', 'subActivity'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Gagal memuat data sub kegiatan: ' . $th->getMessage());
        }
    }

    public function updateSubActivity(Request $request, $activityId, $subActivityId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        try {
            $subActivity = SubActivity::findOrFail($subActivityId);
            $subActivity->update([
                'title' => $request->title,
            ]);

            return redirect()->route('admin.activities.show', $activityId)
                ->with('success', 'Sub kegiatan berhasil diperbarui');
        } catch (\Throwable $th) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui sub kegiatan: ' . $th->getMessage())
                ->withInput();
        }
    }

    public function destroySubActivity($activityId, $subActivityId)
    {
        try {
            $subActivity = SubActivity::with('villageActivities')->findOrFail($subActivityId);

            // Hitung jumlah village activities yang akan terhapus
            $villageActivitiesCount = $subActivity->villageActivities->count();

            // Delete sub activity (cascade akan menghapus village activities juga)
            $subActivity->delete();

            $message = 'Sub kegiatan berhasil dihapus';
            if ($villageActivitiesCount > 0) {
                $message .= ' beserta ' . $villageActivitiesCount . ' data kegiatan desa terkait';
            }

            return redirect()->back()->with('success', $message);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Gagal menghapus sub kegiatan: ' . $th->getMessage());
        }
    }

    // Target Activity Methods
    public function storeTargetActivity(Request $request, $activityId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        try {
            TargetActivity::create([
                'activity_id' => $activityId,
                'title' => $request->title,
            ]);

            return redirect()->back()->with('success', 'Target kegiatan berhasil ditambahkan');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Gagal menambahkan target kegiatan: ' . $th->getMessage());
        }
    }

    public function editTargetActivity($activityId, $targetActivityId)
    {
        try {
            $activity = $this->activityService->getActivityById($activityId);
            $targetActivity = TargetActivity::findOrFail($targetActivityId);

            if (!$activity) {
                return redirect()->route('admin.activities.index')
                    ->with('error', 'Data kegiatan tidak ditemukan');
            }

            return view('pages.admin.activity.edit_target_activity', compact('activity', 'targetActivity'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Gagal memuat data target kegiatan: ' . $th->getMessage());
        }
    }

    public function updateTargetActivity(Request $request, $activityId, $targetActivityId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        try {
            $targetActivity = TargetActivity::findOrFail($targetActivityId);
            $targetActivity->update([
                'title' => $request->title,
            ]);

            return redirect()->route('admin.activities.show', $activityId)
                ->with('success', 'Target kegiatan berhasil diperbarui');
        } catch (\Throwable $th) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui target kegiatan: ' . $th->getMessage())
                ->withInput();
        }
    }

    public function destroyTargetActivity($activityId, $targetActivityId)
    {
        try {
            $targetActivity = TargetActivity::findOrFail($targetActivityId);
            $targetActivity->delete();

            return redirect()->back()->with('success', 'Target kegiatan berhasil dihapus');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Gagal menghapus target kegiatan');
        }
    }

    // Innovation Activity Methods
    public function storeInnovationActivity(Request $request, $activityId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        try {
            InnovationActivity::create([
                'activity_id' => $activityId,
                'title' => $request->title,
            ]);

            return redirect()->back()->with('success', 'Inovasi kegiatan berhasil ditambahkan');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Gagal menambahkan inovasi kegiatan: ' . $th->getMessage());
        }
    }

    public function editInnovationActivity($activityId, $innovationActivityId)
    {
        try {
            $activity = $this->activityService->getActivityById($activityId);
            $innovationActivity = InnovationActivity::findOrFail($innovationActivityId);

            if (!$activity) {
                return redirect()->route('admin.activities.index')
                    ->with('error', 'Data kegiatan tidak ditemukan');
            }

            return view('pages.admin.activity.edit_innovation_activity', compact('activity', 'innovationActivity'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Gagal memuat data inovasi kegiatan: ' . $th->getMessage());
        }
    }

    public function updateInnovationActivity(Request $request, $activityId, $innovationActivityId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        try {
            $innovationActivity = InnovationActivity::findOrFail($innovationActivityId);
            $innovationActivity->update([
                'title' => $request->title,
            ]);

            return redirect()->route('admin.activities.show', $activityId)
                ->with('success', 'Inovasi kegiatan berhasil diperbarui');
        } catch (\Throwable $th) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui inovasi kegiatan: ' . $th->getMessage())
                ->withInput();
        }
    }

    public function destroyInnovationActivity($activityId, $innovationActivityId)
    {
        try {
            $innovationActivity = InnovationActivity::findOrFail($innovationActivityId);
            $innovationActivity->delete();

            return redirect()->back()->with('success', 'Inovasi kegiatan berhasil dihapus');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Gagal menghapus inovasi kegiatan');
        }
    }

    // Impact Activity Methods
    public function storeImpactActivity(Request $request, $activityId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        try {
            ImpactActivity::create([
                'activity_id' => $activityId,
                'title' => $request->title,
            ]);

            return redirect()->back()->with('success', 'Dampak kegiatan berhasil ditambahkan');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Gagal menambahkan dampak kegiatan: ' . $th->getMessage());
        }
    }

    public function editImpactActivity($activityId, $impactActivityId)
    {
        try {
            $activity = $this->activityService->getActivityById($activityId);
            $impactActivity = ImpactActivity::findOrFail($impactActivityId);

            if (!$activity) {
                return redirect()->route('admin.activities.index')
                    ->with('error', 'Data kegiatan tidak ditemukan');
            }

            return view('pages.admin.activity.edit_impact_activity', compact('activity', 'impactActivity'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Gagal memuat data dampak kegiatan: ' . $th->getMessage());
        }
    }

    public function updateImpactActivity(Request $request, $activityId, $impactActivityId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        try {
            $impactActivity = ImpactActivity::findOrFail($impactActivityId);
            $impactActivity->update([
                'title' => $request->title,
            ]);

            return redirect()->route('admin.activities.show', $activityId)
                ->with('success', 'Dampak kegiatan berhasil diperbarui');
        } catch (\Throwable $th) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui dampak kegiatan: ' . $th->getMessage())
                ->withInput();
        }
    }

    public function destroyImpactActivity($activityId, $impactActivityId)
    {
        try {
            $impactActivity = ImpactActivity::findOrFail($impactActivityId);
            $impactActivity->delete();

            return redirect()->back()->with('success', 'Dampak kegiatan berhasil dihapus');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Gagal menghapus dampak kegiatan');
        }
    }

    // Progress Method
    public function progress(ProgressDataTable $dataTable, $id)
    {
        $activity = $this->activityService->getActivityById($id);

        if (!$activity) {
            return redirect()->route('admin.activities.index')
                ->with('error', 'Data kegiatan tidak ditemukan');
        }

        // Load subActivities relation
        $activity->load('subActivities');
        // dd($activity);

        // Debug activity dan sub activities
        // $subActivityIds = $activity->subActivities->pluck('id')->toArray();
        // dd($subActivityIds);

        // Get village activities untuk activity ini - langsung dari sub_activity_id
        $villageActivitiesRaw = VillageActivity::where(function ($query) use ($activity) {
            $subActivityIds = $activity->subActivities->pluck('id')->toArray();
            $query->whereIn('sub_activity_id', $subActivityIds);
        })->with('village')->get();


        // Loop dan hitung persentase untuk setiap village
        $villages = collect();
        foreach ($villageActivitiesRaw->groupBy('village_id') as $villageId => $activities) {
            $village = $activities->first()->village;

            $totalActivities = $activities->count();
            $completedActivities = 0;

            foreach ($activities as $villageActivity) {
                if ($villageActivity->status === 'completed') {
                    $completedActivities++;
                }
            }

            $village->total_activities = $totalActivities;
            $village->completed_activities = $completedActivities;
            $village->village_activities = $activities;

            $villages->push($village);
        }
        // dd($villages);

        // Sort by completed activities descending
        $villages = $villages->sortByDesc('completed_activities')->values();

        return $dataTable->render('pages.admin.activity.progress', compact('activity', 'villages'));
    }

    public function progressDetail($activityId, $villageId)
    {
        $activity = $this->activityService->getActivityById($activityId);
        $village = Village::findOrFail($villageId);

        if (!$activity) {
            return redirect()->route('admin.activities.index')
                ->with('error', 'Data kegiatan tidak ditemukan');
        }

        // Load village activities for this village and activity
        $subActivityIds = $activity->subActivities->pluck('id')->toArray();
        $villageActivities = VillageActivity::where('village_id', $villageId)
            ->whereIn('sub_activity_id', $subActivityIds)
            ->with('subActivity')
            ->get();

        return view('pages.admin.activity.detail_progress', compact('activity', 'village', 'villageActivities'));
    }
}
