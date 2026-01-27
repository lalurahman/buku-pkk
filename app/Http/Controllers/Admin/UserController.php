<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\UserDistrictDataTable;
use App\DataTables\Admin\UserVillageDataTable;
use App\Exports\UserDistrictExport;
use App\Exports\UserVillageExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Services\ActivityService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
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

    public function district(UserDistrictDataTable $dataTable)
    {
        return $dataTable->render('pages.admin.user.district.index');
    }

    public function districtExport()
    {
        return Excel::download(new UserDistrictExport, 'user-kecamatan-' . date('Y-m-d') . '.xlsx');
    }

    public function village(UserVillageDataTable $dataTable)
    {
        return $dataTable->render('pages.admin.user.village.index');
    }

    public function villageExport()
    {
        return Excel::download(new UserVillageExport, 'user-desa-' . date('Y-m-d') . '.xlsx');
    }

    public function show($id)
    {
        $user = $this->userService->getUserById($id);

        // Determine if district or village user
        $type = $user->userHasDistricts->isNotEmpty() ? 'district' : 'village';

        return view('pages.admin.user.' . $type . '.show', compact('user'));
    }

    public function edit($id)
    {
        $user = $this->userService->getUserById($id);

        // Determine if district or village user
        $type = $user->userHasDistricts->isNotEmpty() ? 'district' : 'village';

        return view('pages.admin.user.' . $type . '.edit', compact('user'));
    }

    // update 
    public function update(UserRequest $request, $id)
    {
        try {
            $user = $this->userService->getUserById($id);
            $updatedUser = $this->userService->updateUser($user, $request->validated());

            $this->activityService->log(
                'admin',
                $this->user()->id,
                'update',
                'Mengubah data user ' . $updatedUser->name
            );

            // Determine redirect route based on user type
            $route = $updatedUser->userHasDistricts->isNotEmpty()
                ? 'admin.user.districts.show'
                : 'admin.user.villages.show';

            return redirect()->route($route, $updatedUser->id)
                ->with('success', 'Data user berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui data user: ' . $e->getMessage())
                ->withInput();
        }
    }
}
