<?php

namespace App\Services;

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
}
