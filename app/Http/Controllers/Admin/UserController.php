<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\UserDistrictDataTable;
use App\DataTables\Admin\UserVillageDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function district(UserDistrictDataTable $dataTable)
    {
        return $dataTable->render('pages.admin.user.district.index');
    }

    public function village(UserVillageDataTable $dataTable)
    {
        return $dataTable->render('pages.admin.user.village.index');
    }
}
