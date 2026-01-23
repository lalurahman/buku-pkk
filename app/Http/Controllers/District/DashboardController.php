<?php

namespace App\Http\Controllers\District;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('pages.district.dashboard.index');
    }
}
