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
        Schema::table('goals', function (Blueprint $table) {
            // Update existing type enum to include new values
            DB::statement("ALTER TABLE goals MODIFY COLUMN type ENUM('client_set', 'trainer_set', 'program_based', 'milestone', 'primary', 'secondary', 'long_term', 'short_term') DEFAULT 'trainer_set'");
            $table->boolean('is_active_for_matching')->default(false)->after('notes');
            $table->json('medical_considerations')->nullable()->after('is_active_for_matching');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('goals', function (Blueprint $table) {
            $table->dropColumn(['type', 'is_active_for_matching', 'medical_considerations']);
        });
    }
};
