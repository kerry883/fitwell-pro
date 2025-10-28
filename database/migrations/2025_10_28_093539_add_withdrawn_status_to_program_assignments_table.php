<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add 'withdrawn' status to the ENUM column
        DB::statement("ALTER TABLE program_assignments MODIFY COLUMN status ENUM('pending', 'active', 'completed', 'paused', 'cancelled', 'rejected', 'deactivated', 'pending_payment', 'withdrawn') NOT NULL DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove 'withdrawn' status from the ENUM column
        DB::statement("ALTER TABLE program_assignments MODIFY COLUMN status ENUM('pending', 'active', 'completed', 'paused', 'cancelled', 'rejected', 'deactivated', 'pending_payment') NOT NULL DEFAULT 'pending'");
    }
};
