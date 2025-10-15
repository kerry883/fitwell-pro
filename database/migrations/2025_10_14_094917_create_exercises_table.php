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
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('category', ['strength', 'cardio', 'flexibility', 'balance', 'sports'])->default('strength');
            $table->json('muscle_groups')->nullable(); // JSON array of muscle groups
            $table->string('equipment_needed')->nullable();
            $table->text('instructions')->nullable();
            $table->integer('calories_per_minute')->nullable();
            $table->string('video_url')->nullable();
            $table->string('image_url')->nullable();
            $table->timestamps();
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
