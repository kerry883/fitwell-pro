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
        Schema::create('client_subscriptions', function (Blueprint $table) {
            // Primary Key
            $table->id();

            // Foreign Keys
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('package_id')->constrained('packages')->onDelete('cascade');

            // Subscription Period
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->date('next_billing_date')->nullable();

            // Billing Details
            $table->enum('billing_frequency', ['MONTHLY', 'QUARTERLY', 'YEARLY', 'ONE_TIME']);
            $table->decimal('amount', 10, 2);
            $table->string('currency')->default('USD');

            // Subscription Status
            $table->enum('status', ['ACTIVE', 'PAUSED', 'CANCELLED', 'EXPIRED'])->default('ACTIVE');

            // Auto-renewal
            $table->boolean('auto_renew')->default(true);

            // Timestamps and Soft Deletes
            $table->timestamps();
            $table->timestamp('cancelled_at')->nullable();
            $table->softDeletes();

            // Indexes for performance
            $table->index(['client_id', 'status']);
            $table->index('package_id');
            $table->index('next_billing_date');
            $table->index('billing_frequency');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_subscriptions');
    }
};
