<?php

use App\Http\Controllers\Trainer\TrainerDashboardController;
use App\Http\Controllers\Trainer\TrainerClientController;
use App\Http\Controllers\Trainer\TrainerProgramController;
use App\Http\Controllers\Trainer\TrainerProfileController;
use App\Http\Controllers\Trainer\TrainerScheduleController;
use App\Http\Controllers\Trainer\TrainerAnalyticsController;
use App\Http\Controllers\Trainer\TrainerAssignmentController;
use App\Http\Controllers\Trainer\ClientNoteController;
use App\Http\Controllers\Trainer\ClientScheduleController;
use App\Http\Controllers\Trainer\GoalController;
use App\Http\Controllers\Trainer\NutritionPlanController;
use App\Http\Controllers\Trainer\MealController;
use App\Http\Controllers\Trainer\SettingsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Trainer Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for trainer users. These routes
| are loaded by the RouteServiceProvider within the "trainer" middleware group.
| All routes here are prefixed with '/trainer' and require authentication.
|
*/

Route::middleware(['auth', 'trainer'])->prefix('trainer')->name('trainer.')->group(function () {
    
    // Trainer Dashboard
    Route::get('/dashboard', [TrainerDashboardController::class, 'index'])->name('dashboard');
    
    // Clients Management
    Route::controller(TrainerClientController::class)->prefix('clients')->name('clients.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{id}', 'show')->name('show');
        Route::get('/{id}/activate', 'activate')->name('activate');
        Route::post('/{id}/activate', 'processActivation')->name('process-activation');
        Route::patch('/{id}/deactivate', 'deactivate')->name('deactivate');
    });
    
    // Client Notes Management
    Route::controller(ClientNoteController::class)->prefix('clients/{clientId}/notes')->name('clients.notes.')->group(function () {
        Route::get('/', 'getClientNotes')->name('index');
        Route::post('/', 'store')->name('store');
        Route::patch('/{noteId}', 'update')->name('update');
        Route::delete('/{noteId}', 'destroy')->name('destroy');
    });
    
    // Client Schedule Management
    Route::controller(ClientScheduleController::class)->prefix('clients/{clientId}/schedule')->name('clients.schedule.')->group(function () {
        Route::get('/', 'getClientSchedules')->name('index');
        Route::post('/', 'store')->name('store');
        Route::patch('/{scheduleId}', 'update')->name('update');
        Route::delete('/{scheduleId}', 'destroy')->name('destroy');
        Route::patch('/{scheduleId}/complete', 'markCompleted')->name('complete');
        Route::patch('/{scheduleId}/missed', 'markMissed')->name('missed');
    });
    
    // Client Goals Management
    Route::controller(GoalController::class)->prefix('clients/{clientId}/goals')->name('clients.goals.')->group(function () {
        Route::get('/', 'getClientGoals')->name('index');
        Route::post('/', 'store')->name('store');
        Route::patch('/{goalId}', 'update')->name('update');
        Route::delete('/{goalId}', 'destroy')->name('destroy');
        Route::post('/{goalId}/progress', 'addProgress')->name('progress');
    });
    
    // Programs Management
    Route::resource('programs', TrainerProgramController::class);
    
    // Program Workouts Management
    Route::controller(TrainerProgramController::class)->prefix('programs/{program}')->name('programs.')->group(function () {
        Route::get('workouts/create', 'createWorkout')->name('workouts.create');
        Route::post('workouts', 'storeWorkout')->name('workouts.store');
        Route::get('workouts/{workout}/edit', 'editWorkout')->name('workouts.edit');
        Route::patch('workouts/{workout}', 'updateWorkout')->name('workouts.update');
        Route::delete('workouts/{workout}', 'destroyWorkout')->name('workouts.destroy');
    });
    
    // Nutrition Plans Management
    Route::controller(NutritionPlanController::class)->prefix('programs/{program}/nutrition-plan')->name('programs.nutrition-plan.')->group(function () {
        Route::get('/', 'show')->name('show');
        Route::patch('/', 'update')->name('update');
        Route::delete('/', 'destroy')->name('destroy');
    });
    
    // Meals Management
    Route::controller(MealController::class)->prefix('programs/{program}/meals')->name('programs.meals.')->group(function () {
        Route::post('/', 'store')->name('store');
        Route::patch('/{meal}', 'update')->name('update');
        Route::delete('/{meal}', 'destroy')->name('destroy');
        Route::post('/{meal}/duplicate', 'duplicate')->name('duplicate');
    });
    
    // Assignments Management
    Route::controller(TrainerAssignmentController::class)->prefix('assignments')->name('assignments.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/{id}/approve', 'approve')->name('approve');
        Route::post('/{id}/reject', 'reject')->name('reject');
    });
    
    // Schedule Management
    Route::resource('schedule', TrainerScheduleController::class);
    
    // Analytics
    Route::get('/analytics', [TrainerAnalyticsController::class, 'index'])->name('analytics.index');
    
    // Profile Management
    Route::controller(TrainerProfileController::class)->prefix('profile')->name('profile.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/edit', 'edit')->name('edit');
        Route::patch('/', 'update')->name('update');
        Route::patch('/availability', 'updateAvailability')->name('availability');
        Route::patch('/rates', 'updateRates')->name('rates');
    });
    
    // Settings
    Route::controller(SettingsController::class)->prefix('settings')->name('settings.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::put('/', 'update')->name('update');
    });
});
