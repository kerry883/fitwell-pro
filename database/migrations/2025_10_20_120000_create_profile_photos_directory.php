<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\File;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create the profile_photos directory in storage if it doesn't exist
        $directory = storage_path('app/public/profile_photos');
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No need to delete the directory when rolling back
    }
};
