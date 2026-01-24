<?php

use App\Http\Controllers\District\ActivityController;
use App\Http\Controllers\District\DashboardController;
use App\Http\Controllers\District\VillageController;
use Illuminate\Support\Facades\Route;

Route::prefix('kecamatan')
    ->name('district.')
    ->middleware(['auth', 'district'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Activity Routes
        Route::resource('activities', ActivityController::class);

        // Village Routes
        Route::resource('villages', VillageController::class)->only(['index', 'show']);
    });
