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
        Schema::create('performance_metrics', function (Blueprint $table) {
            // Primary Key
            $table->id();

            // Foreign Keys
            $table->foreignId('entry_id')->nullable()->constrained('progress_entries')->onDelete('cascade');
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('exercise_id')->nullable()->constrained('exercises')->onDelete('set null');

            // Metric Details
            $table->date('recorded_date');
            $table->enum('metric_type', ['STRENGTH', 'CARDIO', 'FLEXIBILITY', 'ENDURANCE']);
            $table->string('metric_name');
            $table->decimal('metric_value', 10, 2);
            $table->string('metric_unit')->nullable();

            // Additional Notes
            $table->text('notes')->nullable();

            // Timestamps and Soft Deletes
            $table->timestamps();
            $table->softDeletes();

            // Indexes for performance
            $table->index(['client_id', 'recorded_date']);
            $table->index(['client_id', 'exercise_id']);
            $table->index('entry_id');
            $table->index('metric_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('performance_metrics');
    }
};
