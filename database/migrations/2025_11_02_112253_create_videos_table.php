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
        Schema::create('videos', function (Blueprint $table) {
            // Primary Key
            $table->id();

            // Foreign Keys
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('session_id')->nullable()->constrained('workout_sessions')->onDelete('set null');
            $table->foreignId('exercise_id')->nullable()->constrained('exercises')->onDelete('set null');

            // Video Type
            $table->enum('video_type', [
                'FORM_CHECK',
                'PROGRESS_VIDEO',
                'WORKOUT_COMPLETION',
                'MEAL_PREP',
                'CHECK_IN',
                'INJURY_ASSESSMENT'
            ]);

            // Video Information
            $table->string('video_url');
            $table->string('thumbnail_url')->nullable();
            $table->integer('duration_seconds')->unsigned()->nullable();

            // Client Notes and Context
            $table->text('client_notes')->nullable();
            $table->date('recorded_date')->nullable();

            // Review Status
            $table->enum('review_status', [
                'PENDING',
                'IN_REVIEW',
                'REVIEWED',
                'APPROVED',
                'NEEDS_REVISION'
            ])->default('PENDING');

            // Timestamps and Soft Deletes
            $table->timestamp('uploaded_at')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Indexes for performance
            $table->index(['client_id', 'review_status']);
            $table->index('session_id');
            $table->index('exercise_id');
            $table->index('video_type');
            $table->index('recorded_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
