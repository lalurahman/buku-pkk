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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
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

    public function destroySubActivity($activityId, $subActivityId)
    {
        try {
            $subActivity = SubActivity::findOrFail($subActivityId);
            $subActivity->delete();

            return redirect()->back()->with('success', 'Sub kegiatan berhasil dihapus');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Gagal menghapus sub kegiatan');
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
}
