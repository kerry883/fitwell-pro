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
        Schema::table('client_profiles', function (Blueprint $table) {
            // Onboarding tracking fields
            $table->boolean('onboarding_completed')->default(false)->after('user_id');
            $table->timestamp('onboarding_completed_at')->nullable()->after('onboarding_completed');
            $table->integer('onboarding_step')->default(0)->after('onboarding_completed_at');
            
            // Equipment access for matching algorithm (JSON array)
            $table->json('equipment_access')->nullable()->after('preferred_workout_types');
            
            // Enhanced medical screening
            $table->text('medical_notes')->nullable()->after('medications');
            $table->boolean('medical_clearance')->default(false)->after('medical_notes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('client_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'onboarding_completed',
                'onboarding_completed_at',
                'onboarding_step',
                'equipment_access',
                'medical_notes',
                'medical_clearance',
            ]);
        });
    }
};
