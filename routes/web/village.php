<?php

use App\Http\Controllers\Village\ActivityController;
use App\Http\Controllers\Village\DashboardController;
use Illuminate\Support\Facades\Route;

Route::prefix('desa')
    ->name('village.')
    ->middleware(['auth', 'village'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Activity Routes
        Route::prefix('activities')->name('activities.')->group(function () {
            Route::get('/', [ActivityController::class, 'index'])->name('index');
            Route::get('/{id}', [ActivityController::class, 'show'])->name('show');
            Route::post('/{activityId}/village-activities/{villageActivityId}/update-status', [ActivityController::class, 'updateStatus'])->name('village-activities.update-status');
        });
    });
