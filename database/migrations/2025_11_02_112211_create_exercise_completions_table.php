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
        Schema::create('exercise_completions', function (Blueprint $table) {
            // Primary Key
            $table->id();

            // Foreign Keys
            $table->foreignId('completion_id')->constrained('workout_completions')->onDelete('cascade');
            $table->foreignId('session_exercise_id')->constrained('session_exercises')->onDelete('cascade');

            // Actual Performance Data
            $table->integer('sets_completed')->unsigned()->nullable();
            $table->integer('reps_completed')->unsigned()->nullable();
            $table->decimal('weight_used', 10, 2)->nullable();
            $table->integer('duration_seconds')->unsigned()->nullable();
            $table->decimal('distance_completed', 10, 2)->nullable();

            // Exercise-specific Notes
            $table->text('notes')->nullable();

            // Timestamps and Soft Deletes
            $table->timestamps();
            $table->softDeletes();

            // Indexes for performance
            $table->index('completion_id');
            $table->index('session_exercise_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercise_completions');
    }
};
