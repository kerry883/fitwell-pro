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
        Schema::create('group_sessions', function (Blueprint $table) {
            // Primary Key
            $table->id();

            // Foreign Keys
            $table->foreignId('appointment_id')->constrained('appointments')->onDelete('cascade');
            $table->foreignId('trainer_id')->constrained('users')->onDelete('cascade');

            // Session Details
            $table->string('session_name');
            $table->text('description')->nullable();

            // Participant Management
            $table->integer('max_participants')->unsigned();
            $table->integer('current_participants')->unsigned()->default(0);

            // Pricing
            $table->decimal('price_per_person', 10, 2)->nullable();

            // Status
            $table->enum('status', ['OPEN', 'FULL', 'CANCELLED', 'COMPLETED'])->default('OPEN');

            // Timestamps and Soft Deletes
            $table->timestamps();
            $table->softDeletes();

            // Indexes for performance
            $table->index('appointment_id');
            $table->index('trainer_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_sessions');
    }
};
