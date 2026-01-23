<?php

use App\Http\Controllers\District\DashboardController;
use Illuminate\Support\Facades\Route;

Route::prefix('kecamatan')
    ->name('district.')
    ->middleware(['auth', 'district'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    });
