<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\MeetingMinuteDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\MeetingMinuteRequest;
use App\Services\ActivityService;
use App\Services\MeetingMinuteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MeetingMinuteController extends Controller
{
    protected $activityService;
    protected $meetingMinuteService;

    public function __construct(ActivityService $activityService, MeetingMinuteService $meetingMinuteService)
    {
        $this->activityService = $activityService;
        $this->meetingMinuteService = $meetingMinuteService;
    }

    private function user()
    {
        return Auth::user();
    }
    /**
     * Display a listing of the resource.
     */
    public function index(MeetingMinuteDataTable $dataTable)
    {
        return $dataTable->render('pages.admin.meeting_minute.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MeetingMinuteRequest $request)
    {
        try {
            $meetingMinute = $this->meetingMinuteService->createMeetingMinute($request->validated());

            $this->activityService->log(
                'admin',
                $this->user()->id,
                'create',
                'Menambahkan notulensi rapat tanggal ' . $meetingMinute->meeting_date
            );

            return redirect()->route('admin.meeting-minutes.index')
                ->with('success', 'Notulensi rapat berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menambahkan notulensi rapat: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $meetingMinute = $this->meetingMinuteService->getMeetingMinuteById($id);
        return view('pages.admin.meeting_minute.show', compact('meetingMinute'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $meetingMinute = $this->meetingMinuteService->getMeetingMinuteById($id);
        return view('pages.admin.meeting_minute.edit', compact('meetingMinute'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MeetingMinuteRequest $request, string $id)
    {
        try {
            $meetingMinute = $this->meetingMinuteService->getMeetingMinuteById($id);
            $updatedMeetingMinute = $this->meetingMinuteService->updateMeetingMinute($meetingMinute, $request->validated());

            $this->activityService->log(
                'admin',
                $this->user()->id,
                'update',
                'Mengubah notulensi rapat tanggal ' . $updatedMeetingMinute->meeting_date
            );

            return redirect()->route('admin.meeting-minutes.show', $updatedMeetingMinute->id)
                ->with('success', 'Notulensi rapat berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui notulensi rapat: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $meetingMinute = $this->meetingMinuteService->getMeetingMinuteById($id);
            $meetingDate = $meetingMinute->meeting_date;

            $this->meetingMinuteService->deleteMeetingMinute($meetingMinute);

            $this->activityService->log(
                'admin',
                $this->user()->id,
                'delete',
                'Menghapus notulensi rapat tanggal ' . $meetingDate
            );

            return redirect()->route('admin.meeting-minutes.index')
                ->with('success', 'Notulensi rapat berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus notulensi rapat: ' . $e->getMessage());
        }
    }
}
