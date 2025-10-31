<?php<?php



use Illuminate\Database\Migrations\Migration;use Illuminate\Database\Migrations\Migration;

use Illuminate\Database\Schema\Blueprint;use Illuminate\Database\Schema\Blueprint;

use Illuminate\Support\Facades\Schema;use Illuminate\Support\Facades\Schema;

use Illuminate\Support\Facades\DB;use Illuminate\Support\Facades\DB;



return new class extends Migrationreturn new class extends Migration

{{

    /**    /**

     * Run the migrations.     * Run the migrations.

     */     */

    public function up(): void    public function up(): void

    {    {

        // For SQLite, create a new table with the desired schema        // Create a temporary table

        Schema::create('temp_program_assignments', function (Blueprint $table) {        Schema::create('temp_program_assignments', function (Blueprint $table) {

            $table->id();            // Copy all columns from program_assignments

            $table->foreignId('client_id')->constrained('client_profiles')->cascadeOnDelete();            $table->id();

            $table->foreignId('program_id')->constrained('programs')->cascadeOnDelete();            $table->foreignId('client_id')->constrained('users');

            $table->date('assigned_date');            $table->foreignId('trainer_id')->constrained('users');

            $table->date('start_date')->nullable();            $table->foreignId('program_id')->constrained('programs');

            $table->timestamp('approved_at')->nullable();            $table->string('status')->default('pending'); // New column with all possible values

            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();            $table->timestamps();

            $table->text('approval_notes')->nullable();        });

            $table->timestamp('payment_deadline')->nullable();        

            $table->timestamp('payment_reminder_sent_at')->nullable();        // Copy data

            $table->date('end_date')->nullable();        DB::statement('INSERT INTO temp_program_assignments SELECT * FROM program_assignments');

            $table->string('status')->default('pending'); // Using string type instead of enum for SQLite        

            $table->integer('current_week')->default(1);        // Drop original table

            $table->integer('current_session')->default(1);        Schema::drop('program_assignments');

            $table->decimal('progress_percentage', 5, 2)->default(0);        

            $table->json('customizations')->nullable();        // Rename temp table

            $table->text('notes')->nullable();        Schema::rename('temp_program_assignments', 'program_assignments');

            $table->timestamp('completed_at')->nullable();    }

            $table->timestamps();

                /**

            $table->unique(['client_id', 'program_id']);     * Reverse the migrations.

        });     */

            public function down(): void

        // Copy data from old table to new table    {

        DB::statement('INSERT INTO temp_program_assignments SELECT * FROM program_assignments');        // Create a temporary table

                Schema::create('temp_program_assignments', function (Blueprint $table) {

        // Drop old table            // Copy all columns from program_assignments

        Schema::dropIfExists('program_assignments');            $table->id();

                    $table->foreignId('client_id')->constrained('users');

        // Rename new table to original name            $table->foreignId('trainer_id')->constrained('users');

        Schema::rename('temp_program_assignments', 'program_assignments');            $table->foreignId('program_id')->constrained('programs');

    }            $table->string('status')->default('pending'); // Revert to original values

            $table->timestamps();

    /**        });

     * Reverse the migrations.        

     */        // Copy data

    public function down(): void        DB::statement('INSERT INTO temp_program_assignments SELECT * FROM program_assignments');

    {        

        Schema::table('program_assignments', function (Blueprint $table) {        // Drop original table

            // For SQLite, we'll do the same in reverse        Schema::drop('program_assignments');

            Schema::create('temp_program_assignments', function (Blueprint $table) {        

                $table->id();        // Rename temp table

                $table->foreignId('client_id')->constrained('client_profiles')->cascadeOnDelete();        Schema::rename('temp_program_assignments', 'program_assignments');

                $table->foreignId('program_id')->constrained('programs')->cascadeOnDelete();    }

                $table->date('assigned_date');};

                $table->date('start_date')->nullable();
                $table->timestamp('approved_at')->nullable();
                $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
                $table->text('approval_notes')->nullable();
                $table->timestamp('payment_deadline')->nullable();
                $table->timestamp('payment_reminder_sent_at')->nullable();
                $table->date('end_date')->nullable();
                $table->string('status')->default('pending'); // Using string type instead of enum for SQLite
                $table->integer('current_week')->default(1);
                $table->integer('current_session')->default(1);
                $table->decimal('progress_percentage', 5, 2)->default(0);
                $table->json('customizations')->nullable();
                $table->text('notes')->nullable();
                $table->timestamp('completed_at')->nullable();
                $table->timestamps();
                
                $table->unique(['client_id', 'program_id']);
            });

            // Copy data excluding 'rejected' status
            DB::statement("INSERT INTO temp_program_assignments SELECT * FROM program_assignments WHERE status != 'rejected'");
            
            // Drop old table
            Schema::dropIfExists('program_assignments');
            
            // Rename new table to original name
            Schema::rename('temp_program_assignments', 'program_assignments');
        });
    }
};