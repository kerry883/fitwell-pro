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
        Schema::create('notification_templates', function (Blueprint $table) {
            // Primary Key
            $table->id();

            // Template Details
            $table->string('template_name')->unique();
            $table->enum('trigger_event', [
                'WELCOME',
                'WORKOUT_REMINDER',
                'MISSED_SESSION',
                'MILESTONE',
                'PAYMENT_DUE',
                'PROGRAM_START',
                'PROGRAM_END'
            ]);

            // Template Content
            $table->string('subject');
            $table->text('email_template')->nullable();
            $table->text('sms_template')->nullable();
            $table->text('push_template')->nullable();

            // Template Variables (JSON)
            $table->json('template_variables')->nullable()->comment('e.g., {"client_name": "{{first_name}}", "workout_name": "{{session_name}}"}');

            // Status
            $table->boolean('is_active')->default(true);

            // Timestamps and Soft Deletes
            $table->timestamps();
            $table->softDeletes();

            // Indexes for performance
            $table->index('trigger_event');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_templates');
    }
};
