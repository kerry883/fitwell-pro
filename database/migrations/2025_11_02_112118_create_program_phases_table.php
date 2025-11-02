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
        Schema::create('program_phases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('template_id')->constrained('program_templates')->onDelete('cascade');
            $table->integer('phase_number');
            $table->string('phase_name');
            $table->text('phase_description')->nullable();
            $table->integer('duration_weeks');
            $table->json('phase_goals')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('template_id');
            $table->index(['template_id', 'phase_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_phases');
    }
};
