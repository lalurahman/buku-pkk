<?php

namespace App\Services;

use App\Models\Activity;
use Illuminate\Support\Facades\Http;

class ActivityService
{
    public function log($logName, $userId, $activityType, $description)
    {
        activity()
            ->useLog($logName) // nama log
            ->event($activityType) // Jenis aktivitas
            ->causedBy($userId) // user sebagai pelaku
            ->withProperties([
                'ip_address' => request()->ip(),
                'user_agent' => request()->header('user-agent'),
            ])
            ->log($description); // keterangan aktivitas
    }

    public function createActivity($data)
    {
        $activity = Activity::create([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'start_date' => $data['start_date'] ?? null,
            'end_date' => $data['end_date'] ?? null,
        ]);

        return $activity;
    }

    public function getActivityById($id)
    {
        return Activity::with([
            'subActivities',
            'targetActivities',
            'innovationActivities',
            'impactActivities'
        ])->find($id);
    }

    public function updateActivity($activity, $data)
    {
        $activity->update([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'start_date' => $data['start_date'] ?? null,
            'end_date' => $data['end_date'] ?? null,
        ]);

        return $activity;
    }
}
