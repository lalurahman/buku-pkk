<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Services\ActivityService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    protected $activityService;
    protected $userService;

    public function __construct(ActivityService $activityService, UserService $userService)
    {
        $this->activityService = $activityService;
        $this->userService = $userService;
    }

    private function user()
    {
        return Auth::user();
    }

    public function index()
    {
        $user = $this->user();
        $role = $this->user()->getRoleNames()->first();
        // dd($role);
        return view('pages.profile.index', compact('user'));
    }

    public function update(UserRequest $request, $id)
    {
        try {
            // Ensure user can only update their own profile
            if ($this->user()->id != $id) {
                return redirect()->back()
                    ->with('error', 'Anda tidak memiliki akses untuk mengubah profile ini.');
            }

            $user = $this->userService->getUserById($id);
            $updatedUser = $this->userService->updateUser($user, $request->validated());

            $this->activityService->log(
                'admin',
                $this->user()->id,
                'update',
                'Mengubah profile sendiri'
            );

            return redirect()->route('profile.index')
                ->with('success', 'Profile berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui profile: ' . $e->getMessage())
                ->withInput();
        }
    }
}
