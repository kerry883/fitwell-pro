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
        Schema::create('client_goals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('goal_title');
            $table->text('goal_description')->nullable();
            $table->enum('goal_type', [
                'WEIGHT_LOSS',
                'MUSCLE_GAIN',
                'STRENGTH',
                'ENDURANCE',
                'FLEXIBILITY',
                'HEALTH',
                'SPORT_SPECIFIC',
                'OTHER'
            ]);
            $table->decimal('target_value', 10, 2)->nullable();
            $table->string('target_unit')->nullable();
            $table->date('target_date')->nullable();
            $table->enum('status', ['ACTIVE', 'COMPLETED', 'PAUSED', 'CANCELLED'])->default('ACTIVE');
            $table->decimal('current_progress', 10, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('user_id');
            $table->index(['user_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_goals');
    }
};
