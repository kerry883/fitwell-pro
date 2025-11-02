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
        Schema::create('trainer_availabilities', function (Blueprint $table) {
            // Primary Key
            $table->id();

            // Foreign Key
            $table->foreignId('trainer_id')->constrained('users')->onDelete('cascade');

            // Availability Details
            $table->enum('day_of_week', [
                'MONDAY',
                'TUESDAY',
                'WEDNESDAY',
                'THURSDAY',
                'FRIDAY',
                'SATURDAY',
                'SUNDAY'
            ]);
            $table->time('start_time');
            $table->time('end_time');

            // Recurrence Settings
            $table->boolean('is_recurring')->default(true);
            $table->date('effective_from')->nullable();
            $table->date('effective_until')->nullable();

            // Slot Configuration
            $table->integer('slot_duration_minutes')->unsigned()->default(60);
            $table->integer('buffer_time_minutes')->unsigned()->default(0)->comment('Buffer time between appointments');

            // Status
            $table->boolean('is_active')->default(true);

            // Timestamps and Soft Deletes
            $table->timestamps();
            $table->softDeletes();

            // Indexes for performance
            $table->index(['trainer_id', 'day_of_week']);
            $table->index(['trainer_id', 'is_active']);
            $table->index(['effective_from', 'effective_until']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainer_availabilities');
    }
};
