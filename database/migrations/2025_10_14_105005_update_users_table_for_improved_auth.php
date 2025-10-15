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
        Schema::table('users', function (Blueprint $table) {
            // Replace 'name' with first_name and last_name
            $table->dropColumn('name');
            $table->string('first_name')->after('id');
            $table->string('last_name')->after('first_name');
            
            // Update fitness fields
            $table->dropColumn(['date_of_birth', 'gender', 'fitness_goal']);
            $table->integer('age')->nullable()->after('user_type');
            $table->enum('fitness_level', ['beginner', 'intermediate', 'advanced'])->nullable()->after('weight');
            $table->text('fitness_goals')->nullable()->after('activity_level');
            
            // Add social auth enhancements
            $table->text('provider_token')->nullable()->after('provider_name');
            $table->boolean('needs_profile_completion')->default(false)->after('provider_token');
            
            // Update activity_level enum values
            $table->dropColumn('activity_level');
            $table->enum('activity_level', ['sedentary', 'lightly_active', 'moderately_active', 'very_active', 'extremely_active'])->default('moderately_active')->after('fitness_level');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Reverse the changes
            $table->dropColumn(['first_name', 'last_name', 'age', 'fitness_level', 'fitness_goals', 'provider_token', 'needs_profile_completion']);
            $table->string('name')->after('id');
            $table->date('date_of_birth')->nullable()->after('user_type');
            $table->enum('gender', ['male', 'female', 'other'])->nullable()->after('date_of_birth');
            $table->enum('fitness_goal', ['lose_weight', 'maintain_weight', 'gain_weight', 'build_muscle', 'improve_endurance'])->default('maintain_weight')->after('activity_level');
            
            // Restore original activity_level
            $table->dropColumn('activity_level');
            $table->enum('activity_level', ['sedentary', 'lightly_active', 'moderately_active', 'very_active', 'extra_active'])->default('moderately_active')->after('weight');
        });
    }
};
