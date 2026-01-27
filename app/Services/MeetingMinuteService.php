<?php

namespace App\Services;

use App\Models\MeetingMinute;

class MeetingMinuteService
{
    /**
     * Create a new meeting minute record
     */
    public function createMeetingMinute(array $data): MeetingMinute
    {
        $meetingMinute = MeetingMinute::create([
            'meeting_date' => $data['meeting_date'],
            'location' => $data['location'],
            'start_time' => $data['start_time'],
            'end_time' => $data['end_time'] ?? null,
            'meeting_type' => $data['meeting_type'] ?? null,
            'leader' => $data['leader'] ?? null,
            'invited_count' => $data['invited_count'] ?? null,
            'attended_count' => $data['attended_count'] ?? null,
            'agenda' => $data['agenda'] ?? null,
            'discussion' => $data['discussion'] ?? null,
            'conclusion' => $data['conclusion'] ?? null,
            'follow_up' => $data['follow_up'] ?? null,
        ]);

        return $meetingMinute;
    }

    /**
     * Get meeting minute by ID
     */
    public function getMeetingMinuteById(string $id): ?MeetingMinute
    {
        return MeetingMinute::findOrFail($id);
    }

    /**
     * Update an existing meeting minute record
     */
    public function updateMeetingMinute(MeetingMinute $meetingMinute, array $data): MeetingMinute
    {
        $meetingMinute->update([
            'meeting_date' => $data['meeting_date'],
            'location' => $data['location'],
            'start_time' => $data['start_time'],
            'end_time' => $data['end_time'] ?? $meetingMinute->end_time,
            'meeting_type' => $data['meeting_type'] ?? $meetingMinute->meeting_type,
            'leader' => $data['leader'] ?? $meetingMinute->leader,
            'invited_count' => $data['invited_count'] ?? $meetingMinute->invited_count,
            'attended_count' => $data['attended_count'] ?? $meetingMinute->attended_count,
            'agenda' => $data['agenda'] ?? $meetingMinute->agenda,
            'discussion' => $data['discussion'] ?? $meetingMinute->discussion,
            'conclusion' => $data['conclusion'] ?? $meetingMinute->conclusion,
            'follow_up' => $data['follow_up'] ?? $meetingMinute->follow_up,
        ]);

        return $meetingMinute->fresh();
    }

    /**
     * Delete a meeting minute record
     */
    public function deleteMeetingMinute(MeetingMinute $meetingMinute): bool
    {
        return $meetingMinute->delete();
    }
}
