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
        Schema::create('payments', function (Blueprint $table) {
            // Primary Key
            $table->id();

            // Foreign Keys (Polymorphic relationships)
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('subscription_id')->nullable()->constrained('client_subscriptions')->onDelete('set null');
            $table->foreignId('appointment_id')->nullable()->constrained('appointments')->onDelete('set null');
            $table->foreignId('client_program_id')->nullable()->constrained('client_programs')->onDelete('set null');

            // Invoice Reference
            $table->string('invoice_number')->nullable();

            // Payment Amount
            $table->decimal('amount', 10, 2);
            $table->string('currency')->default('USD');

            // Payment Type and Method
            $table->enum('payment_type', ['ONE_TIME', 'SUBSCRIPTION', 'SESSION', 'PROGRAM']);
            $table->enum('payment_method', ['CARD', 'BANK_TRANSFER', 'CASH', 'MOBILE_MONEY', 'OTHER']);

            // Payment Dates
            $table->date('payment_date')->nullable();
            $table->date('due_date')->nullable();

            // Payment Status
            $table->enum('status', ['PENDING', 'COMPLETED', 'FAILED', 'REFUNDED', 'CANCELLED'])->default('PENDING');

            // Transaction Details
            $table->string('transaction_id')->nullable();
            $table->text('notes')->nullable();

            // Timestamps and Soft Deletes
            $table->timestamps();
            $table->softDeletes();

            // Indexes for performance
            $table->index(['client_id', 'status']);
            $table->index('subscription_id');
            $table->index('appointment_id');
            $table->index('client_program_id');
            $table->index('payment_type');
            $table->index('payment_date');
            $table->index('transaction_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
