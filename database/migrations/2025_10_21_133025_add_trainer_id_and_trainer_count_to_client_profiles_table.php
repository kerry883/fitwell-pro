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
            $table->foreignId('trainer_id')->nullable()->constrained('users')->onDelete('set null')->after('user_id');
            $table->integer('trainer_count')->default(0)->after('trainer_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('client_profiles', function (Blueprint $table) {
            $table->dropForeign(['trainer_id']);
            $table->dropColumn(['trainer_id', 'trainer_count']);
        });
    }
};
