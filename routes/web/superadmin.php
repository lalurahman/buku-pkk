<?php

use App\Http\Controllers\Superadmin\DashboardController;
use Illuminate\Support\Facades\Route;

Route::prefix('superadmin')
    ->name('superadmin.')
    ->middleware(['auth', 'superadmin'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    });
