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
        Schema::create('recurring_patterns', function (Blueprint $table) {
            // Primary Key
            $table->id();

            // Recurrence Type
            $table->enum('recurrence_type', ['DAILY', 'WEEKLY', 'BIWEEKLY', 'MONTHLY']);

            // Recurrence Rules (JSON for flexibility)
            $table->json('recurrence_rules')->nullable()->comment('e.g., {"pattern": "weekly", "days": ["MONDAY", "WEDNESDAY"], "time": "18:00"}');

            // Date Range
            $table->date('start_date');
            $table->date('end_date')->nullable();

            // Occurrence Limit
            $table->integer('occurrences_count')->unsigned()->nullable();

            // Excluded Dates (JSON array)
            $table->json('excluded_dates')->nullable()->comment('Array of dates to skip, e.g., ["2025-12-25", "2026-01-01"]');

            // Timestamps and Soft Deletes
            $table->timestamps();
            $table->softDeletes();

            // Indexes for performance
            $table->index('recurrence_type');
            $table->index(['start_date', 'end_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recurring_patterns');
    }
};
