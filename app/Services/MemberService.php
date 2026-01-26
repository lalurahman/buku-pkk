<?php

namespace App\Services;

use App\Models\Member;

class MemberService
{
    public function createMember($data)
    {
        try {
            $member = Member::create([
                'name' => $data['name'],
                'registration_number' => $data['registration_number'],
                'member_role_id' => $data['member_role_id'],
                'functional_position_id' => $data['functional_position_id'],
                'date_of_birth' => $data['date_of_birth'] ?? null,
                'marital_status' => $data['marital_status'] ?? null,
                'address' => $data['address'] ?? null,
                'phone_number' => $data['phone_number'] ?? null,
                'education' => $data['education'] ?? null,
                'job' => $data['job'] ?? null,
                'status' => 'active',
            ]);

            return $member;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getMemberById($id)
    {
        return Member::find($id);
    }

    public function updateMember($member, $data)
    {
        try {
            $member->update([
                'name' => $data['name'],
                'registration_number' => $data['registration_number'],
                'member_role_id' => $data['member_role_id'],
                'functional_position_id' => $data['functional_position_id'],
                'date_of_birth' => $data['date_of_birth'] ?? $member->date_of_birth,
                'marital_status' => $data['marital_status'] ?? $member->marital_status,
                'address' => $data['address'] ?? $member->address,
                'phone_number' => $data['phone_number'] ?? $member->phone_number,
                'education' => $data['education'] ?? $member->education,
                'job' => $data['job'] ?? $member->job,
            ]);

            return $member;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
