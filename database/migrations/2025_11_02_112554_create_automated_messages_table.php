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
        Schema::create('automated_messages', function (Blueprint $table) {
            // Primary Key
            $table->id();

            // Foreign Keys
            $table->foreignId('template_id')->constrained('notification_templates')->onDelete('cascade');
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade');

            // Trigger Configuration
            $table->enum('trigger_condition', ['TIME_BASED', 'EVENT_BASED', 'CONDITION_BASED']);
            $table->json('trigger_rules')->nullable()->comment('Rules defining when to send the message');

            // Scheduling
            $table->dateTime('scheduled_for')->nullable();

            // Status
            $table->enum('status', ['PENDING', 'SENT', 'FAILED', 'CANCELLED'])->default('PENDING');
            $table->timestamp('sent_at')->nullable();

            // Timestamps and Soft Deletes
            $table->timestamps();
            $table->softDeletes();

            // Indexes for performance
            $table->index(['client_id', 'status']);
            $table->index('template_id');
            $table->index(['scheduled_for', 'status']);
            $table->index('trigger_condition');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('automated_messages');
    }
};
