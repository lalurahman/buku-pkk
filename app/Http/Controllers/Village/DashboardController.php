<?php

namespace App\Http\Controllers\Village;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('pages.village.dashboard.index');
    }
}
