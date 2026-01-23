<?php

use App\Http\Controllers\Village\DashboardController;
use Illuminate\Support\Facades\Route;

Route::prefix('desa')
    ->name('village.')
    ->middleware(['auth', 'village'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    });
