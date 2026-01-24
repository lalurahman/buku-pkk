<?php

namespace App\Http\Controllers\District;

use App\DataTables\District\ActivityDataTable;
use App\Http\Controllers\Controller;
use App\Models\UserHasDistrict;
use App\Models\VillageActivity;
use App\Models\UserHasVillage;
use App\Services\ActivityService;
use App\Services\GalleryActivityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    protected $activityService;
    protected $galleryActivityService;

    public function __construct(
        ActivityService $activityService,
        GalleryActivityService $galleryActivityService
    ) {
        $this->activityService = $activityService;
        $this->galleryActivityService = $galleryActivityService;
    }

    private function user()
    {
        return Auth::user();
    }

    public function index(ActivityDataTable $dataTable)
    {
        return $dataTable->render('pages.district.activity.index');
    }

    public function show($id)
    {
        $activity = $this->activityService->getActivityById($id);

        if (!$activity) {
            return redirect()->route('district.activities.index')
                ->with('error', 'Data kegiatan tidak ditemukan');
        }

        // Get village_id dari user yang login
        $userHasDistrict = UserHasDistrict::where('user_id', $this->user()->id)->first();
        $districtId = $userHasDistrict ? $userHasDistrict->district_id : null;

        // Get village activities terkait activity ini untuk district user
        $villageActivities = [];
        if ($districtId) {
            $villageActivities = VillageActivity::whereHas('village', function ($query) use ($districtId) {
                $query->where('district_id', $districtId);
            })->whereHas('subActivity', function ($query) use ($id) {
                $query->where('activity_id', $id);
            })->with(['village', 'subActivity'])->get();
        }
        // dd($villageActivities);

        return view('pages.district.activity.show', [
            'activity' => $activity,
            'villageActivities' => $villageActivities
        ]);
    }

    public function updateStatus(Request $request, $activityId, $villageActivityId)
    {
        $request->validate([
            'status' => 'required|in:pending,completed',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $villageActivity = VillageActivity::findOrFail($villageActivityId);

            $villageActivity->update([
                'status' => $request->status,
                'finish_date' => $request->status === 'completed' ? now() : null,
            ]);

            // Upload gambar jika ada menggunakan service
            if ($request->hasFile('images')) {
                $this->galleryActivityService->uploadImages(
                    $request->file('images'),
                    $villageActivity->id
                );
            }

            return redirect()->back()->with('success', 'Status kegiatan berhasil diperbarui');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Gagal memperbarui status: ' . $th->getMessage());
        }
    }
}
