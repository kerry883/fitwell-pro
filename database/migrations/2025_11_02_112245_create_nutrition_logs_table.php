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
        Schema::create('nutrition_logs', function (Blueprint $table) {
            // Primary Key
            $table->id();

            // Foreign Keys
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('nutrition_plan_id')->nullable()->constrained('nutrition_plans')->onDelete('set null');

            // Log Details
            $table->date('log_date');
            $table->enum('meal_type', ['BREAKFAST', 'LUNCH', 'DINNER', 'SNACK', 'OTHER']);
            $table->text('meal_description');

            // Nutritional Information
            $table->decimal('calories', 8, 2)->nullable();
            $table->decimal('protein', 8, 2)->nullable();
            $table->decimal('carbs', 8, 2)->nullable();
            $table->decimal('fat', 8, 2)->nullable();

            // Documentation
            $table->string('photo_url')->nullable();
            $table->text('notes')->nullable();

            // Timestamps and Soft Deletes
            $table->timestamp('logged_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Indexes for performance
            $table->index(['client_id', 'log_date']);
            $table->index('nutrition_plan_id');
            $table->index('meal_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nutrition_logs');
    }
};
