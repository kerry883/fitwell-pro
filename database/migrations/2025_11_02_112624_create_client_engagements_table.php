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
        Schema::create('client_engagements', function (Blueprint $table) {
            // Primary Key
            $table->id();

            // Foreign Key
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade');

            // Tracking Date
            $table->date('tracking_date');

            // Engagement Metrics
            $table->integer('workouts_completed')->unsigned()->default(0);
            $table->integer('videos_uploaded')->unsigned()->default(0);
            $table->integer('messages_sent')->unsigned()->default(0);
            $table->integer('logins_count')->unsigned()->default(0);

            // Completion Rate
            $table->decimal('completion_rate', 5, 2)->nullable()->comment('Percentage of workouts completed vs assigned');

            // Last Activity
            $table->timestamp('last_activity')->nullable();

            // Timestamps and Soft Deletes
            $table->timestamps();
            $table->softDeletes();

            // Indexes for performance
            $table->index(['client_id', 'tracking_date']);
            $table->index('last_activity');
            $table->unique(['client_id', 'tracking_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_engagements');
    }
};
