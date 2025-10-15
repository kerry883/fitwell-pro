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
        Schema::create('nutrition_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('food_name');
            $table->decimal('quantity', 8, 2); // amount consumed
            $table->string('unit'); // grams, cups, pieces, etc.
            $table->integer('calories');
            $table->decimal('protein', 8, 2)->nullable(); // in grams
            $table->decimal('carbohydrates', 8, 2)->nullable(); // in grams
            $table->decimal('fat', 8, 2)->nullable(); // in grams
            $table->decimal('fiber', 8, 2)->nullable(); // in grams
            $table->decimal('sugar', 8, 2)->nullable(); // in grams
            $table->enum('meal_type', ['breakfast', 'lunch', 'dinner', 'snack'])->default('snack');
            $table->date('consumed_date');
            $table->time('consumed_time')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nutrition_entries');
    }
};
