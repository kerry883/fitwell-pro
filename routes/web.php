<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\Auth\OtpVerificationController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public routes
Route::get('/', function () {
    return view('home');
})->name('home');

// Stripe Webhook (must be outside auth middleware and CSRF protection)
Route::post('/stripe/webhook', [\App\Http\Controllers\PaymentController::class, 'webhook'])->name('stripe.webhook');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    
    // Registration
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    // Social Authentication (Google and Facebook)
    Route::get('/auth/{provider}/redirect', [SocialAuthController::class, 'redirect'])
         ->name('social.redirect')
         ->where('provider', 'google|facebook');
    Route::get('/auth/{provider}/callback', [SocialAuthController::class, 'callback'])
         ->name('social.callback')
         ->where('provider', 'google|facebook');

    // OTP Verification
    Route::get('/verify-otp', [OtpVerificationController::class, 'showVerificationForm'])->name('verify.otp.form');
    Route::post('/verify-otp', [OtpVerificationController::class, 'verifyOtp'])->name('verify.otp');
    Route::post('/send-otp', [OtpVerificationController::class, 'sendOtp'])->name('send.otp');
});

/*
|--------------------------------------------------------------------------
| Protected Routes (All Authenticated Users)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    // Profile Completion (for social login users)
    Route::get('/profile/complete', [RegisterController::class, 'showProfileCompletion'])->name('profile.complete');
    Route::post('/profile/complete', [RegisterController::class, 'completeProfile']);
    
    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Dashboard - Role-based redirect
    Route::get('/dashboard', function() {
        $user = Auth::user();

        if ($user->isTrainer()) {
            return redirect()->route('trainer.dashboard');
        } elseif ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('client.dashboard');
        }
    })->name('dashboard');

    // Notifications (shared across all user types)
    Route::controller(NotificationController::class)->prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', 'showNotificationsPage')->name('index');
        Route::get('/all', 'getAll')->name('all');
        Route::get('/unread-count', 'unreadCount')->name('unread-count');
        Route::get('/{id}', 'show')->name('show');
        Route::patch('/{id}/read', 'markAsRead')->name('mark-read');
        Route::post('/{id}/read', 'markAsRead')->name('mark-read.post');
        Route::patch('/mark-all-read', 'markAllAsRead')->name('mark-all-read');
        Route::post('/mark-all-read', 'markAllAsRead')->name('mark-all-read.post');
        Route::delete('/{id}', 'destroy')->name('destroy');
        Route::delete('/delete-all', 'deleteAll')->name('delete-all');
    });
});
