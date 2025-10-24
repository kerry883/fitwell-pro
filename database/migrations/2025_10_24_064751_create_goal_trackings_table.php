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
        Schema::create('goal_trackings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('goal_id')->constrained('goals')->onDelete('cascade');
            $table->foreignId('client_id')->constrained('client_profiles')->onDelete('cascade');
            $table->decimal('value', 8, 2);
            $table->string('unit')->nullable();
            $table->date('tracking_date');
            $table->text('notes')->nullable();
            $table->enum('entry_type', ['manual', 'automatic', 'measurement', 'workout', 'assessment'])->default('manual');
            $table->json('metadata')->nullable(); // Store additional context like workout_id, measurement_type, etc.
            $table->timestamps();

            $table->index(['goal_id', 'tracking_date']);
            $table->index(['client_id', 'tracking_date']);
            $table->unique(['goal_id', 'tracking_date']); // One entry per goal per day
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goal_trackings');
    }
};
