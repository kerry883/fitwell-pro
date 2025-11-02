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
        Schema::create('appointments', function (Blueprint $table) {
            // Primary Key
            $table->id();

            // Foreign Keys
            $table->foreignId('trainer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('client_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('recurring_pattern_id')->nullable()->constrained('recurring_patterns')->onDelete('set null');

            // Session Type
            $table->enum('session_type', ['INDIVIDUAL', 'GROUP'])->default('INDIVIDUAL');

            // Appointment Details
            $table->string('title');
            $table->text('description')->nullable();

            // Scheduling
            $table->dateTime('scheduled_start');
            $table->dateTime('scheduled_end');

            // Location/Meeting
            $table->string('location')->nullable();
            $table->string('meeting_link')->nullable();

            // Status
            $table->enum('status', [
                'SCHEDULED',
                'CONFIRMED',
                'COMPLETED',
                'CANCELLED',
                'NO_SHOW',
                'RESCHEDULED'
            ])->default('SCHEDULED');

            // Recurrence Flag
            $table->boolean('is_recurring')->default(false);

            // Cancellation
            $table->text('cancellation_reason')->nullable();

            // Timestamps and Soft Deletes
            $table->timestamps();
            $table->softDeletes();

            // Indexes for performance
            $table->index(['trainer_id', 'scheduled_start']);
            $table->index(['client_id', 'scheduled_start']);
            $table->index('status');
            $table->index('session_type');
            $table->index('recurring_pattern_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
