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
        Schema::table('program_assignments', function (Blueprint $table) {
            $table->timestamp('approved_at')->nullable()->after('start_date');
            $table->unsignedBigInteger('approved_by')->nullable()->after('approved_at');
            $table->text('approval_notes')->nullable()->after('approved_by');
            $table->timestamp('payment_deadline')->nullable()->after('approval_notes');
            $table->timestamp('payment_reminder_sent_at')->nullable()->after('payment_deadline');
            
            // Foreign key for approved_by (references users table)
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('program_assignments', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);
            $table->dropColumn([
                'approved_at',
                'approved_by',
                'approval_notes',
                'payment_deadline',
                'payment_reminder_sent_at'
            ]);
        });
    }
};
