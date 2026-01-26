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
        Route::get('main-members', [MemberController::class, 'mainMember'])->name('members.main.index');

        // Activity Relations Routes
        Route::prefix('activities/{activity}')->name('activities.')->group(function () {
            Route::post('sub-activities', [ActivityController::class, 'storeSubActivity'])->name('sub-activities.store');
            Route::get('sub-activities/{subActivity}/edit', [ActivityController::class, 'editSubActivity'])->name('sub-activities.edit');
            Route::put('sub-activities/{subActivity}', [ActivityController::class, 'updateSubActivity'])->name('sub-activities.update');
            Route::delete('sub-activities/{subActivity}', [ActivityController::class, 'destroySubActivity'])->name('sub-activities.destroy');

            Route::post('target-activities', [ActivityController::class, 'storeTargetActivity'])->name('target-activities.store');
            Route::get('target-activities/{targetActivity}/edit', [ActivityController::class, 'editTargetActivity'])->name('target-activities.edit');
            Route::put('target-activities/{targetActivity}', [ActivityController::class, 'updateTargetActivity'])->name('target-activities.update');
            Route::delete('target-activities/{targetActivity}', [ActivityController::class, 'destroyTargetActivity'])->name('target-activities.destroy');

            Route::post('innovation-activities', [ActivityController::class, 'storeInnovationActivity'])->name('innovation-activities.store');
            Route::get('innovation-activities/{innovationActivity}/edit', [ActivityController::class, 'editInnovationActivity'])->name('innovation-activities.edit');
            Route::put('innovation-activities/{innovationActivity}', [ActivityController::class, 'updateInnovationActivity'])->name('innovation-activities.update');
            Route::delete('innovation-activities/{innovationActivity}', [ActivityController::class, 'destroyInnovationActivity'])->name('innovation-activities.destroy');

            Route::post('impact-activities', [ActivityController::class, 'storeImpactActivity'])->name('impact-activities.store');
            Route::get('impact-activities/{impactActivity}/edit', [ActivityController::class, 'editImpactActivity'])->name('impact-activities.edit');
            Route::put('impact-activities/{impactActivity}', [ActivityController::class, 'updateImpactActivity'])->name('impact-activities.update');
            Route::delete('impact-activities/{impactActivity}', [ActivityController::class, 'destroyImpactActivity'])->name('impact-activities.destroy');
        });

        // Progress Route
        Route::get('activities/{id}/progress', [ActivityController::class, 'progress'])->name('activities.progress');
        // detail progress
        Route::get('activities/{id}/progress-detail/{villageId}', [ActivityController::class, 'progressDetail'])->name('activities.progress-detail');
    });
