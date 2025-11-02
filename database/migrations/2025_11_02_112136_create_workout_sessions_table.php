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
        Schema::create('workout_sessions', function (Blueprint $table) {
            // Primary Key
            $table->id();

            // Foreign Keys
            $table->foreignId('client_program_id')->constrained('client_programs')->onDelete('cascade');
            $table->foreignId('phase_id')->nullable()->constrained('program_phases')->onDelete('set null');

            // Session Details
            $table->integer('week_number')->unsigned();
            $table->integer('day_number')->unsigned();
            $table->string('session_name');
            $table->text('description')->nullable();
            $table->enum('session_type', ['STRENGTH', 'CARDIO', 'FLEXIBILITY', 'HYBRID', 'REST'])->default('STRENGTH');
            $table->integer('estimated_duration_minutes')->unsigned()->nullable();

            // Warm-up and Cool-down (JSON for flexibility)
            $table->json('warm_up')->nullable();
            $table->json('cool_down')->nullable();

            // Ordering
            $table->integer('sort_order')->unsigned()->default(0);

            // Timestamps and Soft Deletes
            $table->timestamps();
            $table->softDeletes();

            // Indexes for performance
            $table->index(['client_program_id', 'week_number']);
            $table->index(['client_program_id', 'day_number']);
            $table->index('phase_id');
            $table->index('session_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workout_sessions');
    }
};
