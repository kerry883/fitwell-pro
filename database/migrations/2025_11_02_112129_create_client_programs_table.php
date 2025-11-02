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
        Schema::create('client_programs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('template_id')->constrained('program_templates')->onDelete('cascade');
            $table->foreignId('assigned_by_trainer_id')->constrained('users')->onDelete('cascade');
            $table->string('program_name');
            $table->enum('assignment_type', ['STATIC', 'DYNAMIC_PROGRESSIVE'])->default('STATIC');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->enum('status', ['ACTIVE', 'COMPLETED', 'PAUSED', 'CANCELLED'])->default('ACTIVE');
            $table->integer('current_week')->default(1);
            $table->integer('current_phase')->default(1);
            $table->boolean('auto_advance')->default(false);
            $table->json('customizations')->nullable();
            $table->timestamp('assigned_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('client_id');
            $table->index('template_id');
            $table->index(['client_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_programs');
    }
};
