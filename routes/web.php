<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\AdminDashboardController as ControllersAdminDashboardController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ClientProgramController;
use App\Http\Controllers\ClientAssignmentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NutritionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\WorkoutController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\Trainer\TrainerDashboardController;
use App\Http\Controllers\Trainer\TrainerClientController;
use App\Http\Controllers\Trainer\TrainerProgramController;
use App\Http\Controllers\Trainer\TrainerProfileController;
use App\Http\Controllers\Trainer\ProfilePhotoController;
use App\Http\Controllers\Trainer\TrainerScheduleController;
use App\Http\Controllers\Trainer\TrainerAnalyticsController;
use App\Http\Controllers\Trainer\TrainerAssignmentController;
use App\Http\Controllers\Auth\OtpVerificationController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Public routes
Route::get('/', function () {
    return view('home');
})->name('home');

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    // Social authentication (Google and Facebook)
    Route::get('/auth/{provider}/redirect', [SocialAuthController::class, 'redirect'])
         ->name('social.redirect')
         ->where('provider', 'google|facebook');
    Route::get('/auth/{provider}/callback', [SocialAuthController::class, 'callback'])
         ->name('social.callback')
         ->where('provider', 'google|facebook');

    // OTP Verification routes
    Route::get('/verify-otp', [OtpVerificationController::class, 'showVerificationForm'])->name('verify.otp.form');
    Route::post('/verify-otp', [OtpVerificationController::class, 'verifyOtp'])->name('verify.otp');
    Route::post('/send-otp', [OtpVerificationController::class, 'sendOtp'])->name('send.otp');

    // Note: Admin authentication routes have been moved to routes/admin.php
});

// Protected routes
Route::middleware('auth')->group(function () {
    // Profile completion (for social login users)
    Route::get('/profile/complete', [RegisterController::class, 'showProfileCompletion'])->name('profile.complete');
    Route::post('/profile/complete', [RegisterController::class, 'completeProfile']);
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Dashboard - with role-based redirect
    Route::get('/dashboard', function() {
        $user = Auth::user();

        if ($user->isTrainer()) {
            return redirect()->route('trainer.dashboard');
        } elseif ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } else {
            return app(DashboardController::class)->index();
        }
    })->name('dashboard');

    // Trainer routes - grouped and protected
    Route::prefix('trainer')->name('trainer.')->middleware(['auth', 'trainer'])->group(function () {
        // Trainer Dashboard
        Route::get('/dashboard', [TrainerDashboardController::class, 'index'])->name('dashboard');

        // Trainer Clients Management
        Route::get('/clients', [TrainerClientController::class, 'index'])->name('clients.index');
        Route::get('/clients/{id}', [TrainerClientController::class, 'show'])->name('clients.show');

        // Trainer Programs Management
        Route::resource('programs', TrainerProgramController::class);

        // Trainer Assignments Management
        Route::get('/assignments', [TrainerAssignmentController::class, 'index'])->name('assignments.index');
        Route::post('/assignments/{id}/approve', [TrainerAssignmentController::class, 'approve'])->name('assignments.approve');
        Route::post('/assignments/{id}/reject', [TrainerAssignmentController::class, 'reject'])->name('assignments.reject');

        // Program Workouts Management
        Route::prefix('programs/{program}')->name('programs.')->group(function () {
            Route::get('workouts/create', [TrainerProgramController::class, 'createWorkout'])->name('workouts.create');
            Route::post('workouts', [TrainerProgramController::class, 'storeWorkout'])->name('workouts.store');
            Route::get('workouts/{workout}/edit', [TrainerProgramController::class, 'editWorkout'])->name('workouts.edit');
            Route::patch('workouts/{workout}', [TrainerProgramController::class, 'updateWorkout'])->name('workouts.update');
            Route::delete('workouts/{workout}', [TrainerProgramController::class, 'destroyWorkout'])->name('workouts.destroy');
        });

        // Trainer Schedule Management
        Route::resource('schedule', TrainerScheduleController::class);

        // Trainer Analytics
        Route::get('/analytics', [TrainerAnalyticsController::class, 'index'])->name('analytics.index');

        // Trainer Profile Management
        Route::get('/profile', [TrainerProfileController::class, 'index'])->name('profile.index');
        Route::get('/profile/edit', [TrainerProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [TrainerProfileController::class, 'update'])->name('profile.update');
        Route::patch('/profile/availability', [TrainerProfileController::class, 'updateAvailability'])->name('profile.availability');
        Route::patch('/profile/rates', [TrainerProfileController::class, 'updateRates'])->name('profile.rates');

        // Trainer Logout
        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    });

    // Client Programs
    Route::get('/programs', [ClientProgramController::class, 'index'])->name('programs.index');
    Route::get('/programs/{id}', [ClientProgramController::class, 'show'])->name('programs.show');
    Route::post('/programs/{id}/enroll', [ClientProgramController::class, 'enroll'])->name('programs.enroll');

    // Client Assignments
    Route::prefix('client')->name('client.')->group(function () {
        Route::get('/assignments', [ClientAssignmentController::class, 'index'])->name('assignments.index');
        Route::get('/assignments/{id}', [ClientAssignmentController::class, 'show'])->name('assignments.show');
        Route::delete('/assignments/{id}/withdraw', [ClientAssignmentController::class, 'withdraw'])->name('assignments.withdraw');
        Route::patch('/assignments/{id}/progress', [ClientAssignmentController::class, 'updateProgress'])->name('assignments.update-progress');
    });

    // Workouts
    Route::resource('workouts', WorkoutController::class);

    // Nutrition
    Route::resource('nutrition', NutritionController::class);

    // Progress Tracking
    Route::resource('progress', ProgressController::class);

    // Calendar
    Route::resource('calendar', CalendarController::class);
    Route::post('/calendar/{id}', [CalendarController::class, 'update'])->name('calendar.update');

    // Settings
    Route::resource('settings', SettingsController::class);

    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::patch('/profile/goals', [ProfileController::class, 'updateGoals'])->name('profile.update-goals');
    Route::patch('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/photo', [ProfileController::class, 'uploadPhoto'])->name('profile.upload-photo');
});

// Note: All admin routes have been moved to routes/admin.php for better separation of concerns
