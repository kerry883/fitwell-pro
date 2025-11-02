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
        Schema::create('session_participants', function (Blueprint $table) {
            // Primary Key
            $table->id();

            // Foreign Keys
            $table->foreignId('group_session_id')->constrained('group_sessions')->onDelete('cascade');
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade');

            // Participation Details
            $table->dateTime('joined_at')->nullable();
            $table->enum('attendance_status', ['REGISTERED', 'ATTENDED', 'ABSENT', 'CANCELLED'])->default('REGISTERED');

            // Notes
            $table->text('notes')->nullable();

            // Timestamps and Soft Deletes
            $table->timestamps();
            $table->softDeletes();

            // Indexes for performance
            $table->index('group_session_id');
            $table->index('client_id');
            $table->index('attendance_status');
            $table->unique(['group_session_id', 'client_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_participants');
    }
};
