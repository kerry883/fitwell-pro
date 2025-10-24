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
        Schema::create('goals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('client_profiles')->onDelete('cascade');
            $table->foreignId('trainer_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('category', ['weight_loss', 'weight_gain', 'muscle_building', 'strength', 'endurance', 'flexibility', 'general_fitness', 'sports_performance', 'health_improvement', 'other'])->default('general_fitness');
            $table->enum('type', ['primary', 'secondary', 'long_term', 'short_term'])->default('primary');
            $table->enum('measurement_type', ['weight', 'body_fat', 'muscle_mass', 'measurements', 'performance', 'time_based', 'repetition_based', 'distance_based', 'custom'])->default('custom');
            $table->decimal('target_value', 8, 2)->nullable();
            $table->string('target_unit')->nullable(); // kg, lbs, %, cm, reps, minutes, km, etc.
            $table->decimal('current_value', 8, 2)->nullable();
            $table->date('target_date')->nullable();
            $table->date('start_date')->nullable();
            $table->enum('status', ['active', 'completed', 'paused', 'cancelled'])->default('active');
            $table->integer('priority')->default(1); // 1-5, higher number = higher priority
            $table->text('notes')->nullable();
            $table->json('milestones')->nullable(); // Store milestone checkpoints
            $table->timestamps();

            $table->index(['client_id', 'status']);
            $table->index(['trainer_id', 'created_at']);
            $table->index(['category', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goals');
    }
};
