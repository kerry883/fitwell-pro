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
        Schema::create('appointment_reminders', function (Blueprint $table) {
            // Primary Key
            $table->id();

            // Foreign Key
            $table->foreignId('appointment_id')->constrained('appointments')->onDelete('cascade');

            // Reminder Type
            $table->enum('reminder_type', ['EMAIL', 'SMS', 'PUSH', 'IN_APP']);

            // Timing
            $table->integer('minutes_before')->unsigned();

            // Status
            $table->boolean('is_sent')->default(false);
            $table->timestamp('sent_at')->nullable();

            // Timestamps and Soft Deletes
            $table->timestamps();
            $table->softDeletes();

            // Indexes for performance
            $table->index(['appointment_id', 'is_sent']);
            $table->index('reminder_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointment_reminders');
    }
};
