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
        Schema::create('trainer_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Professional information
            $table->text('bio')->nullable();
            $table->json('certifications')->nullable(); // Array of certifications
            $table->json('specializations')->nullable(); // Array of specializations
            $table->integer('years_experience')->nullable();
            $table->string('education')->nullable();
            $table->text('approach_description')->nullable();
            
            // Business information
            $table->string('business_name')->nullable();
            $table->string('business_address')->nullable();
            $table->string('business_phone')->nullable();
            $table->string('business_email')->nullable();
            $table->string('website_url')->nullable();
            $table->json('social_media_links')->nullable();
            
            // Pricing and availability
            $table->decimal('hourly_rate', 8, 2)->nullable();
            $table->decimal('package_rates', 10, 2)->nullable(); // JSON for different packages
            $table->json('availability_schedule')->nullable(); // Weekly schedule
            $table->integer('max_clients')->default(50);
            $table->integer('current_clients')->default(0);
            
            // Settings and preferences
            $table->boolean('accepting_new_clients')->default(true);
            $table->json('training_locations')->nullable(); // gym, home, online, etc.
            $table->text('cancellation_policy')->nullable();
            
            // Status
            $table->enum('status', ['active', 'inactive', 'pending_approval'])->default('pending_approval');
            $table->timestamp('verified_at')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainer_profiles');
    }
};
