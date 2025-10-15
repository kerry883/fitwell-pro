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
        Schema::create('client_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Client-specific fields
            $table->text('fitness_history')->nullable();
            $table->json('medical_conditions')->nullable(); // Array of medical conditions
            $table->json('injuries')->nullable(); // Array of current/past injuries  
            $table->text('medications')->nullable();
            $table->enum('experience_level', ['beginner', 'intermediate', 'advanced'])->default('beginner');
            $table->json('preferred_workout_types')->nullable(); // Array of preferred types
            $table->integer('available_days_per_week')->nullable();
            $table->time('preferred_workout_time')->nullable();
            $table->integer('workout_duration_preference')->nullable(); // in minutes
            $table->text('notes')->nullable();
            
            // Emergency contact
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone')->nullable();
            $table->string('emergency_contact_relationship')->nullable();
            
            // Status and dates
            $table->enum('status', ['active', 'inactive', 'paused'])->default('active');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_profiles');
    }
};
