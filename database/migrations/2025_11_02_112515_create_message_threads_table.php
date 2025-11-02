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
        Schema::create('message_threads', function (Blueprint $table) {
            // Primary Key
            $table->id();

            // Thread Details
            $table->string('thread_subject')->nullable();
            $table->enum('thread_type', ['ONE_ON_ONE', 'GROUP', 'ANNOUNCEMENT'])->default('ONE_ON_ONE');

            // Timestamps and Soft Deletes
            $table->timestamps();
            $table->timestamp('last_message_at')->nullable();
            $table->softDeletes();

            // Indexes for performance
            $table->index('thread_type');
            $table->index('last_message_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('message_threads');
    }
};
