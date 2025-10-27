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
        Schema::create('meal_foods', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category'); // protein, carbs, fats, vegetables, fruits, dairy
            $table->integer('calories_per_100g');
            $table->decimal('protein_per_100g', 5, 2);
            $table->decimal('carbs_per_100g', 5, 2);
            $table->decimal('fats_per_100g', 5, 2);
            $table->decimal('fiber_per_100g', 5, 2)->nullable();
            $table->string('common_serving_size')->nullable(); // e.g., "1 medium apple"
            $table->integer('common_serving_calories')->nullable();
            $table->json('vitamins_minerals')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            
            $table->index(['category', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meal_foods');
    }
};
