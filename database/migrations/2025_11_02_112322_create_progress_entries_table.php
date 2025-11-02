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
        Schema::create('progress_entries', function (Blueprint $table) {
            // Primary Key
            $table->id();

            // Foreign Key
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade');

            // Entry Details
            $table->date('entry_date');
            $table->enum('entry_type', [
                'MEASUREMENT',
                'PERFORMANCE',
                'PHOTO',
                'ASSESSMENT',
                'GENERAL'
            ]);

            // Flexible Data Storage
            $table->json('entry_data')->nullable()->comment('Flexible storage for any entry type specific data');
            $table->text('notes')->nullable();

            // Timestamps and Soft Deletes
            $table->timestamps();
            $table->softDeletes();

            // Indexes for performance
            $table->index(['client_id', 'entry_date']);
            $table->index('entry_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progress_entries');
    }
};
