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
        Schema::create('invoices', function (Blueprint $table) {
            // Primary Key
            $table->id();

            // Foreign Keys
            $table->foreignId('payment_id')->nullable()->constrained('payments')->onDelete('set null');
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade');

            // Invoice Number (Unique)
            $table->string('invoice_number')->unique();

            // Invoice Dates
            $table->date('issue_date');
            $table->date('due_date');

            // Amounts
            $table->decimal('subtotal', 10, 2);
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2);
            $table->string('currency')->default('USD');

            // Invoice Status
            $table->enum('status', ['DRAFT', 'SENT', 'PAID', 'OVERDUE', 'CANCELLED'])->default('DRAFT');

            // Line Items (JSON for flexibility)
            $table->json('line_items')->nullable()->comment('Array of invoice line items with description, quantity, price');

            // Notes and Document
            $table->text('notes')->nullable();
            $table->string('invoice_document_url')->nullable();

            // Timestamps and Soft Deletes
            $table->timestamps();
            $table->softDeletes();

            // Indexes for performance
            $table->index(['client_id', 'status']);
            $table->index('payment_id');
            $table->index('issue_date');
            $table->index('due_date');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
