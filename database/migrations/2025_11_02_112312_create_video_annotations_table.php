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
        Schema::create('video_annotations', function (Blueprint $table) {
            // Primary Key
            $table->id();

            // Foreign Key
            $table->foreignId('feedback_id')->constrained('video_feedbacks')->onDelete('cascade');

            // Annotation Details
            $table->integer('timestamp_seconds')->unsigned()->comment('Timestamp in video where annotation applies');
            $table->text('annotation_text');
            $table->json('position_data')->nullable()->comment('Coordinates for visual markers on video player');

            // Ordering
            $table->integer('sort_order')->unsigned()->default(0);

            // Timestamps and Soft Deletes
            $table->timestamps();
            $table->softDeletes();

            // Indexes for performance
            $table->index(['feedback_id', 'timestamp_seconds']);
            $table->index(['feedback_id', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('video_annotations');
    }
};
