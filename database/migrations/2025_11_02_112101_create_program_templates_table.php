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
        Schema::create('program_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('created_by_trainer_id')->constrained('users')->onDelete('cascade');
            $table->string('template_name');
            $table->text('description')->nullable();
            $table->enum('program_type', ['WORKOUT', 'NUTRITION', 'HYBRID'])->default('WORKOUT');
            $table->enum('difficulty_level', ['BEGINNER', 'INTERMEDIATE', 'ADVANCED'])->default('BEGINNER');
            $table->integer('duration_weeks');
            $table->boolean('is_progressive')->default(false);
            $table->json('phase_structure')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('created_by_trainer_id');
            $table->index(['is_active', 'program_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_templates');
    }
};
