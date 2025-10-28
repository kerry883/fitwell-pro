<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Trainer\ProfilePhotoController;

Route::middleware(['auth', 'trainer'])->group(function () {
    Route::post('/trainer/profile/photo', [ProfilePhotoController::class, 'update'])->name('trainer.profile.photo.update');
});
