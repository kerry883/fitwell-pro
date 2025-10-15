<?php

use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ClientProgramController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NutritionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\WorkoutController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Trainer\TrainerDashboardController;
use App\Http\Controllers\Trainer\TrainerClientController;
use App\Http\Controllers\Trainer\TrainerProgramController;
use App\Http\Controllers\Trainer\TrainerProfileController;
use App\Http\Controllers\Trainer\TrainerScheduleController;
use App\Http\Controllers\Trainer\TrainerAnalyticsController;
use Illuminate\Support\Facades\Route;

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
    
    // Admin authentication routes (manual access only - not linked anywhere)
    Route::prefix('admin')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
        Route::post('/login', [AdminAuthController::class, 'login']);
        Route::get('/register', [AdminAuthController::class, 'showRegistrationForm'])->name('admin.register');
        Route::post('/register', [AdminAuthController::class, 'register']);
    });
});

// Protected routes
Route::middleware('auth')->group(function () {
    // Profile completion (for social login users)
    Route::get('/profile/complete', [RegisterController::class, 'showProfileCompletion'])->name('profile.complete');
    Route::post('/profile/complete', [RegisterController::class, 'completeProfile']);
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    // Admin routes
    Route::prefix('admin')->middleware('auth')->group(function () {
        Route::get('/dashboard', function() {
            return view('admin.dashboard');
        })->name('admin.dashboard');
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
    });

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
    Route::resource('profile', ProfileController::class);
});
