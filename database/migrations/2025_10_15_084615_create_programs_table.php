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
        Schema::create('programs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trainer_id')->constrained('trainer_profiles')->onDelete('cascade');
            $table->string('name');
            $table->text('description');
            $table->integer('duration_weeks');
            $table->enum('difficulty_level', ['beginner', 'intermediate', 'advanced']);
            $table->string('program_type');
            $table->integer('sessions_per_week');
            $table->json('goals')->nullable(); // Array of program goals
            $table->json('equipment_required')->nullable(); // Array of required equipment
            $table->boolean('is_public')->default(false);
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->integer('max_clients')->nullable();
            $table->integer('current_clients')->default(0);
            $table->decimal('price', 8, 2)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
