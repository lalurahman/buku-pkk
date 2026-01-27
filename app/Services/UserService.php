<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /**
     * Get user by ID
     */
    public function getUserById(string $id): ?User
    {
        return User::with(['userHasDistricts.district', 'userHasVillages.village'])
            ->findOrFail($id);
    }

    /**
     * Update an existing user
     */
    public function updateUser(User $user, array $data): User
    {
        $updateData = [
            'name' => $data['name'],
            'email' => $data['email'],
        ];

        // Only update password if provided
        if (!empty($data['password'])) {
            $updateData['password'] = Hash::make($data['password']);
        }

        $user->update($updateData);

        return $user->fresh();
    }
}
