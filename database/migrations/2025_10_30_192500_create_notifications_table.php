<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('notifications', function (Blueprint $table) {
            // Add soft deletes if it doesn't exist
            if (!Schema::hasColumn('notifications', 'deleted_at')) {
                $table->softDeletes();
            }
            
            // Add indexes if they don't exist
            if (!Schema::hasIndex('notifications', 'notifications_user_id_created_at_index')) {
                $table->index(['user_id', 'created_at']);
            }
            if (!Schema::hasIndex('notifications', 'notifications_user_id_is_read_index')) {
                $table->index(['user_id', 'is_read']);
            }
        });
    }

    public function down()
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropIndex(['user_id', 'created_at']);
            $table->dropIndex(['user_id', 'is_read']);
        });
    }
};