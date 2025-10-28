<?php

use App\Http\Controllers\Client\ClientAssignmentController;
use App\Http\Controllers\Client\ClientProgramController;
use App\Http\Controllers\Client\DashboardController;
use App\Http\Controllers\Client\PaymentController;
use App\Http\Controllers\Client\SettingsController;
use App\Http\Controllers\Client\ProfileController;
use App\Http\Controllers\Client\WorkoutController;
use App\Http\Controllers\Client\NutritionController;
use App\Http\Controllers\Client\ProgressController;
use App\Http\Controllers\Client\CalendarController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Client Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for client users. These routes
| are loaded by the RouteServiceProvider within the "client" middleware group.
| All routes here are prefixed with '/client' and require authentication.
|
*/

Route::middleware(['auth', 'role:client'])->prefix('client')->name('client.')->group(function () {
    
    // Client Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Program Management
    Route::controller(ClientProgramController::class)->prefix('programs')->name('programs.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{id}', 'show')->name('show');
        Route::post('/{id}/enroll', 'enroll')->name('enroll');
    });
    
    // Assignment Management
    Route::controller(ClientAssignmentController::class)->prefix('assignments')->name('assignments.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{id}', 'show')->name('show');
        Route::delete('/{id}/withdraw', 'withdraw')->name('withdraw');
        Route::post('/{id}/cancel-payment', 'cancelPaymentAndWithdraw')->name('cancel-payment');
        Route::delete('/{id}', 'destroy')->name('delete');
        Route::patch('/{id}/progress', 'updateProgress')->name('update-progress');
    });
    
    // Payment Management
    Route::controller(PaymentController::class)->prefix('payment')->name('payment.')->group(function () {
        Route::get('/{assignment}/checkout', 'checkout')->name('checkout');
        Route::get('/{assignment}/success', 'success')->name('success');
        Route::get('/failed', 'failed')->name('failed');
        Route::get('/history', 'history')->name('history');
        Route::get('/{payment}/refund', 'requestRefund')->name('refund');
        Route::post('/{payment}/refund', 'processRefund')->name('process-refund');
    });
    
    // Workouts
    Route::resource('workouts', WorkoutController::class);
    
    // Nutrition
    Route::resource('nutrition', NutritionController::class);
    
    // Progress Tracking
    Route::resource('progress', ProgressController::class);
    
    // Calendar
    Route::controller(CalendarController::class)->prefix('calendar')->name('calendar.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{id}', 'show')->name('show');
        Route::get('/{id}/edit', 'edit')->name('edit');
        Route::post('/{id}', 'update')->name('update');
        Route::delete('/{id}', 'destroy')->name('destroy');
    });
    
    // Profile Management
    Route::controller(ProfileController::class)->prefix('profile')->name('profile.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::patch('/', 'updateProfile')->name('update');
        Route::patch('/goals', 'updateGoals')->name('update-goals');
        Route::post('/photo', 'uploadPhoto')->name('upload-photo');
    });
    
    // Settings
    Route::controller(SettingsController::class)->prefix('settings')->name('settings.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::put('/', 'update')->name('update');
    });
});
