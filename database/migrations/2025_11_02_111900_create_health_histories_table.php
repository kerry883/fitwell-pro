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
        Schema::create('health_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->text('medical_conditions')->nullable();
            $table->text('medications')->nullable();
            $table->text('allergies')->nullable();
            $table->text('injuries')->nullable();
            $table->text('surgeries')->nullable();
            $table->boolean('medical_clearance')->default(false);
            $table->string('clearance_document_url')->nullable();
            $table->enum('fitness_level', ['BEGINNER', 'INTERMEDIATE', 'ADVANCED', 'ATHLETE'])->default('BEGINNER');
            $table->text('exercise_limitations')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('health_histories');
    }
};
