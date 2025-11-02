<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('measurements', function (Blueprint $table) {
            // Primary Key
            $table->id();

            // Foreign Keys
            $table->foreignId('entry_id')->nullable()->constrained('progress_entries')->onDelete('cascade');
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade');

            // Measurement Details
            $table->date('measurement_date');

            // Basic Measurements
            $table->decimal('weight', 8, 2)->nullable();
            $table->string('weight_unit')->default('kg');
            $table->decimal('body_fat_percentage', 5, 2)->nullable();
            $table->decimal('muscle_mass', 8, 2)->nullable();

            // Body Measurements (JSON for flexibility)
            $table->json('body_measurements')->nullable()->comment('e.g., {"chest": 100, "waist": 85, "hips": 95, "arms": 35, "thighs": 55}');

            // Timestamps and Soft Deletes
            $table->timestamp('recorded_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Indexes for performance
            $table->index(['client_id', 'measurement_date']);
            $table->index('entry_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('measurements');
    }
};
