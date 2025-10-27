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
            // Add program category field
            $table->enum('program_category', ['fitness', 'nutrition'])
                  ->after('trainer_id')
                  ->default('fitness');
            
            // Rename program_type to program_subtype for clarity
            $table->renameColumn('program_type', 'program_subtype');
            
            // Make fitness-specific fields nullable
            $table->integer('sessions_per_week')->nullable()->change();
            $table->json('equipment_required')->nullable()->change();
            
            // Add nutrition-specific fields
            $table->integer('meals_per_day')->nullable()->after('sessions_per_week');
            $table->json('dietary_preferences')->nullable()->after('goals');
            $table->json('macros_target')->nullable()->after('dietary_preferences');
            $table->integer('calorie_target')->nullable()->after('macros_target');
            $table->boolean('includes_meal_prep')->default(false)->after('calorie_target');
            $table->boolean('includes_shopping_list')->default(false)->after('includes_meal_prep');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('programs', function (Blueprint $table) {
            // Remove nutrition-specific fields
            $table->dropColumn([
                'program_category',
                'meals_per_day',
                'dietary_preferences',
                'macros_target',
                'calorie_target',
                'includes_meal_prep',
                'includes_shopping_list'
            ]);
            
            // Rename back to program_type
            $table->renameColumn('program_subtype', 'program_type');
            
            // Make fitness fields non-nullable again
            $table->integer('sessions_per_week')->nullable(false)->change();
        });
    }
};
