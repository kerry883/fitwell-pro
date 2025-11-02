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
        Schema::create('session_exercises', function (Blueprint $table) {
            // Primary Key
            $table->id();

            // Foreign Keys
            $table->foreignId('session_id')->constrained('workout_sessions')->onDelete('cascade');
            $table->foreignId('exercise_id')->constrained('exercises')->onDelete('cascade');

            // Exercise Order
            $table->integer('exercise_order')->unsigned();

            // Set/Rep Prescription
            $table->integer('sets')->unsigned()->nullable();
            $table->integer('reps')->unsigned()->nullable();
            $table->decimal('weight', 10, 2)->nullable();
            $table->string('weight_unit')->nullable()->default('kg');

            // Duration-based Exercise
            $table->integer('duration_seconds')->unsigned()->nullable();

            // Distance-based Exercise
            $table->decimal('distance', 10, 2)->nullable();
            $table->string('distance_unit')->nullable()->default('km');

            // Rest and Tempo
            $table->integer('rest_seconds')->unsigned()->nullable();
            $table->json('tempo')->nullable(); // e.g., {"eccentric": 3, "pause": 1, "concentric": 1, "top_pause": 0}

            // Notes and Superset Grouping
            $table->text('notes')->nullable();
            $table->boolean('is_superset')->default(false);
            $table->integer('superset_group')->unsigned()->nullable();

            // Timestamps and Soft Deletes
            $table->timestamps();
            $table->softDeletes();

            // Indexes for performance
            $table->index(['session_id', 'exercise_order']);
            $table->index('exercise_id');
            $table->index(['session_id', 'superset_group']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_exercises');
    }
};
