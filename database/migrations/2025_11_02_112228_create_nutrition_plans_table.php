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
            // Primary Key
            $table->id();

            // Foreign Key
            $table->foreignId('client_program_id')->constrained('client_programs')->onDelete('cascade');

            // Plan Details
            $table->string('plan_name');
            $table->text('description')->nullable();

            // Daily Macro Targets
            $table->decimal('daily_calories', 8, 2)->nullable();
            $table->decimal('protein_grams', 8, 2)->nullable();
            $table->decimal('carbs_grams', 8, 2)->nullable();
            $table->decimal('fat_grams', 8, 2)->nullable();

            // Meal Structure
            $table->integer('meals_per_day')->unsigned()->nullable()->default(3);
            $table->json('dietary_restrictions')->nullable(); // e.g., ["vegan", "gluten-free", "dairy-free"]
            $table->json('meal_timing')->nullable(); // e.g., {"breakfast": "07:00", "lunch": "12:00", "dinner": "18:00"}

            // Plan Duration
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            // Status
            $table->enum('status', ['ACTIVE', 'INACTIVE'])->default('ACTIVE');

            // Timestamps and Soft Deletes
            $table->timestamps();
            $table->softDeletes();

            // Indexes for performance
            $table->index('client_program_id');
            $table->index('status');
            $table->index(['start_date', 'end_date']);
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
