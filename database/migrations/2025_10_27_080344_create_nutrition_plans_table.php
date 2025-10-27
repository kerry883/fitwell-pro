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
        Schema::create('nutrition_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')
                  ->constrained('programs')
                  ->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('total_calories')->nullable();
            $table->json('macros')->nullable(); // {protein: 150, carbs: 200, fats: 60, fiber: 30}
            $table->json('meal_timing')->nullable(); // {breakfast: '8:00', lunch: '12:00', ...}
            $table->json('supplements')->nullable(); // Array of supplement recommendations
            $table->text('general_guidelines')->nullable();
            $table->text('hydration_goal')->nullable(); // e.g., "3 liters per day"
            $table->timestamps();
            
            // Each program can have only one nutrition plan
            $table->unique('program_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nutrition_plans');
    }
};
