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
            $table->date('joined_date')->nullable()->after('end_date');
            $table->date('last_session')->nullable()->after('joined_date');
            $table->datetime('next_session')->nullable()->after('last_session');
            $table->enum('progress', ['excellent', 'improving', 'on-track', 'needs-attention'])->nullable()->after('next_session');
            $table->integer('sessions_completed')->default(0)->after('progress');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('client_profiles', function (Blueprint $table) {
            $table->dropColumn(['joined_date', 'last_session', 'next_session', 'progress', 'sessions_completed']);
        });
    }
};
