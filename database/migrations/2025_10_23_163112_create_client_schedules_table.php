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
        Schema::create('client_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('client_profiles')->onDelete('cascade');
            $table->foreignId('trainer_id')->constrained('users')->onDelete('cascade');
            $table->date('scheduled_date');
            $table->time('start_time');
            $table->time('end_time')->nullable();
            $table->string('session_type')->default('training'); // training, consultation, assessment
            $table->string('location')->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', ['scheduled', 'completed', 'cancelled', 'missed'])->default('scheduled');
            $table->timestamp('completed_at')->nullable();
            $table->integer('actual_duration_minutes')->nullable();
            $table->integer('performance_rating')->nullable(); // 1-5 stars
            $table->timestamps();

            $table->index(['client_id', 'scheduled_date']);
            $table->index(['trainer_id', 'scheduled_date']);
            $table->index(['status', 'scheduled_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_schedules');
    }
};
