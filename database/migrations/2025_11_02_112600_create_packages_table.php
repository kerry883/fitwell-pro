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
        Schema::create('packages', function (Blueprint $table) {
            // Primary Key
            $table->id();

            // Foreign Key
            $table->foreignId('created_by_trainer_id')->constrained('users')->onDelete('cascade');

            // Package Details
            $table->string('package_name');
            $table->text('description')->nullable();

            // Package Type
            $table->enum('package_type', ['ONE_TIME', 'SUBSCRIPTION', 'PER_SESSION', 'PER_PROGRAM']);

            // Pricing
            $table->decimal('price', 10, 2);
            $table->string('currency')->default('USD');

            // Duration and Session Count
            $table->integer('duration_days')->unsigned()->nullable();
            $table->integer('session_count')->unsigned()->nullable();

            // Features Included (JSON)
            $table->json('features_included')->nullable()->comment('e.g., {"sessions_per_month": 8, "nutrition_plan": true, "form_checks": "unlimited"}');

            // Status
            $table->boolean('is_active')->default(true);

            // Timestamps and Soft Deletes
            $table->timestamps();
            $table->softDeletes();

            // Indexes for performance
            $table->index('created_by_trainer_id');
            $table->index('package_type');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
