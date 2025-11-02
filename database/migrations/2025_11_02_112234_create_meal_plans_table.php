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
        Schema::create('meal_plans', function (Blueprint $table) {
            // Primary Key
            $table->id();

            // Foreign Key
            $table->foreignId('nutrition_plan_id')->constrained('nutrition_plans')->onDelete('cascade');

            // Meal Type
            $table->enum('meal_type', ['BREAKFAST', 'LUNCH', 'DINNER', 'SNACK', 'PRE_WORKOUT', 'POST_WORKOUT']);

            // Meal Details
            $table->string('meal_name');
            $table->text('description')->nullable();
            $table->text('ingredients')->nullable();
            $table->text('preparation')->nullable();

            // Nutritional Information
            $table->decimal('calories', 8, 2)->nullable();
            $table->decimal('protein', 8, 2)->nullable();
            $table->decimal('carbs', 8, 2)->nullable();
            $table->decimal('fat', 8, 2)->nullable();

            // Additional Information
            $table->string('recipe_url')->nullable();
            $table->json('allergens')->nullable(); // e.g., ["nuts", "dairy", "eggs"]

            // Timestamps and Soft Deletes
            $table->timestamps();
            $table->softDeletes();

            // Indexes for performance
            $table->index('nutrition_plan_id');
            $table->index('meal_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meal_plans');
    }
};
