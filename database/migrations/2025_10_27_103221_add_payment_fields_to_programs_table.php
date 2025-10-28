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
        Schema::table('programs', function (Blueprint $table) {
            $table->boolean('is_free')->default(false)->after('price');
            $table->boolean('requires_approval')->default(true)->after('is_free');
            $table->json('auto_approve_criteria')->nullable()->after('requires_approval');
            $table->integer('payment_deadline_hours')->default(48)->after('auto_approve_criteria');
            $table->integer('refund_policy_days')->default(7)->after('payment_deadline_hours');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('programs', function (Blueprint $table) {
            $table->dropColumn([
                'is_free',
                'requires_approval',
                'auto_approve_criteria',
                'payment_deadline_hours',
                'refund_policy_days'
            ]);
        });
    }
};
