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
        Schema::create('progress_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['weight', 'body_fat', 'muscle_mass', 'measurement', 'photo', 'fitness_test'])->default('weight');
            $table->decimal('value', 8, 2)->nullable(); // numeric value (weight, body fat %, etc.)
            $table->string('unit')->nullable(); // kg, %, cm, etc.
            $table->string('body_part')->nullable(); // for measurements (chest, waist, arms, etc.)
            $table->string('photo_url')->nullable(); // for progress photos
            $table->date('log_date');
            $table->text('notes')->nullable();
            $table->json('additional_data')->nullable(); // for storing extra metrics
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progress_logs');
    }
};
