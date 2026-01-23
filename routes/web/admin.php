<?php

use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Admin\CashFlowController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GuestBookController;
use App\Http\Controllers\Admin\IncomingLetterController;
use App\Http\Controllers\Admin\MeetingMinuteController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\OutgoingLetterController;
use Illuminate\Support\Facades\Route;

Route::prefix('administrator')
    ->name('admin.')
    ->middleware(['auth', 'admin'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Resource Routes
        Route::resources([
            'activities' => ActivityController::class,
            'members' => MemberController::class,
            'cash-flows' => CashFlowController::class,
            'guest-books' => GuestBookController::class,
            'incoming-letters' => IncomingLetterController::class,
            'meeting-minutes' => MeetingMinuteController::class,
            'outgoing-letters' => OutgoingLetterController::class,
        ]);
    });
