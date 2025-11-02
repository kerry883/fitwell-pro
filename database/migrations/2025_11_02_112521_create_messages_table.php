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
        Schema::create('messages', function (Blueprint $table) {
            // Primary Key
            $table->id();

            // Foreign Keys
            $table->foreignId('sender_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('receiver_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('thread_id')->constrained('message_threads')->onDelete('cascade');

            // Message Content
            $table->text('message_content');
            $table->json('attachments')->nullable()->comment('Array of attachment URLs');

            // Read Status
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();

            // Timestamps and Soft Deletes
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Indexes for performance
            $table->index(['thread_id', 'sent_at']);
            $table->index('sender_id');
            $table->index('receiver_id');
            $table->index('is_read');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
