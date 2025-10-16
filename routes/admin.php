<?php

use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use Illuminate\Support\Facades\Route;

// Admin authentication routes (for guests only)
Route::prefix('admin')->middleware(['guest:admin'])->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login']);
});

// Admin routes - separate from web auth
Route::prefix('admin')->middleware(['admin', 'admin.session', 'nocache'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
});

// Admin management routes - for existing admins only
Route::prefix('admin')->middleware(['admin', 'admin.session', 'nocache'])->group(function () {
    Route::get('/register', [AdminAuthController::class, 'showRegistrationForm'])->name('admin.register');
    Route::post('/register', [AdminAuthController::class, 'register']);
});
