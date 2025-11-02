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
        Schema::create('business_metrics', function (Blueprint $table) {
            // Primary Key
            $table->id();

            // Foreign Key
            $table->foreignId('trainer_id')->nullable()->constrained('users')->onDelete('cascade');

            // Metric Date
            $table->date('metric_date');

            // Metric Type
            $table->enum('metric_type', ['RETENTION', 'REVENUE', 'ATTENDANCE', 'SATISFACTION', 'REFERRAL']);

            // Metric Details
            $table->string('metric_name');
            $table->decimal('metric_value', 10, 2);

            // Additional Details (JSON for flexibility)
            $table->json('metric_details')->nullable()->comment('e.g., {"retained_clients": 45, "churned_clients": 3, "new_clients": 8}');

            // Timestamps and Soft Deletes
            $table->timestamp('calculated_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Indexes for performance
            $table->index(['trainer_id', 'metric_date']);
            $table->index('metric_type');
            $table->index(['metric_type', 'metric_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_metrics');
    }
};
