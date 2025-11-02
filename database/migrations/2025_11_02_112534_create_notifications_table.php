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
        Schema::create('notifications', function (Blueprint $table) {
            // Primary Key
            $table->id();

            // Foreign Keys
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->unsignedBigInteger('related_entity_id')->nullable()->comment('Polymorphic ID - can reference any entity');

            // Entity Type (Polymorphic)
            $table->enum('entity_type', [
                'VIDEO',
                'MESSAGE',
                'APPOINTMENT',
                'WORKOUT',
                'PAYMENT',
                'GOAL',
                'ASSESSMENT'
            ])->nullable();

            // Notification Content
            $table->string('notification_title');
            $table->text('notification_content');

            // Notification Type
            $table->enum('notification_type', ['INFO', 'WARNING', 'SUCCESS', 'REMINDER', 'ALERT'])->default('INFO');

            // Read Status
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();

            // Timestamps and Soft Deletes
            $table->timestamps();
            $table->softDeletes();

            // Indexes for performance
            $table->index(['user_id', 'is_read']);
            $table->index(['user_id', 'created_at']);
            $table->index('notification_type');
            $table->index(['entity_type', 'related_entity_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
