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
        Schema::create('workout_completions', function (Blueprint $table) {
            // Primary Key
            $table->id();

            // Foreign Keys
            $table->foreignId('session_id')->constrained('workout_sessions')->onDelete('cascade');
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade');

            // Completion Details
            $table->date('completed_date');
            $table->integer('actual_duration_minutes')->unsigned()->nullable();
            $table->enum('status', ['COMPLETED', 'PARTIAL', 'SKIPPED'])->default('COMPLETED');

            // Client Feedback
            $table->text('notes')->nullable();
            $table->integer('rating')->unsigned()->nullable()->comment('1-5 rating scale');

            // Timestamps and Soft Deletes
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Indexes for performance
            $table->index(['client_id', 'completed_date']);
            $table->index(['session_id', 'client_id']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workout_completions');
    }
};
