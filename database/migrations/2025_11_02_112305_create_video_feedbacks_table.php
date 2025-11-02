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
        Schema::create('video_feedbacks', function (Blueprint $table) {
            // Primary Key
            $table->id();

            // Foreign Keys
            $table->foreignId('video_id')->constrained('videos')->onDelete('cascade');
            $table->foreignId('trainer_id')->constrained('users')->onDelete('cascade');

            // Feedback Content
            $table->text('written_feedback')->nullable();
            $table->string('video_response_url')->nullable()->comment('URL to trainer video response');

            // Rating and Suggestions
            $table->integer('rating')->unsigned()->nullable()->comment('1-5 rating scale');
            $table->json('exercise_suggestions')->nullable(); // Alternative exercises or modifications

            // Follow-up Flag
            $table->boolean('needs_follow_up')->default(false);

            // Timestamps and Soft Deletes
            $table->timestamps();
            $table->softDeletes();

            // Indexes for performance
            $table->index('video_id');
            $table->index('trainer_id');
            $table->index('needs_follow_up');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('video_feedbacks');
    }
};
