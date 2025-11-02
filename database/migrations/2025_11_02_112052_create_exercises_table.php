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
        Schema::create('exercises', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by_trainer_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('category_id')->nullable()->constrained('exercise_categories')->onDelete('set null');
            $table->string('exercise_name');
            $table->text('description')->nullable();
            $table->text('instructions')->nullable();
            $table->enum('difficulty_level', ['BEGINNER', 'INTERMEDIATE', 'ADVANCED'])->default('BEGINNER');
            $table->json('muscle_groups')->nullable();
            $table->json('equipment_needed')->nullable();
            $table->string('video_demo_url')->nullable();
            $table->string('image_url')->nullable();
            $table->json('alternatives')->nullable();
            $table->boolean('is_custom')->default(false);
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('created_by_trainer_id');
            $table->index('category_id');
            $table->index('exercise_name');
            $table->index(['difficulty_level', 'is_custom']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercises');
    }
};
