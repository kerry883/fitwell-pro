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
        Schema::create('meals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nutrition_plan_id')
                  ->constrained('nutrition_plans')
                  ->onDelete('cascade');
            $table->string('name'); // e.g., "Breakfast - High Protein"
            $table->enum('meal_type', [
                'breakfast', 
                'morning_snack', 
                'lunch', 
                'afternoon_snack', 
                'dinner', 
                'evening_snack'
            ]);
            $table->integer('day_number'); // 1-7 (or 1-duration_weeks*7)
            $table->string('meal_time')->nullable(); // e.g., "08:00"
            $table->integer('calories');
            $table->json('macros'); // {protein: 30, carbs: 40, fats: 15, fiber: 5}
            $table->json('ingredients')->nullable(); // Array of {name, quantity, unit}
            $table->text('preparation_instructions')->nullable();
            $table->integer('prep_time_minutes')->nullable();
            $table->json('recipe_images')->nullable(); // Array of image URLs
            $table->json('alternatives')->nullable(); // Alternative meal options
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Index for efficient queries
            $table->index(['nutrition_plan_id', 'day_number', 'meal_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meals');
    }
};
