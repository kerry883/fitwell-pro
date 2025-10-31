<?php<?php<?php<?php



use Illuminate\Database\Migrations\Migration;

use Illuminate\Database\Schema\Blueprint;

use Illuminate\Support\Facades\Schema;use Illuminate\Database\Migrations\Migration;

use Illuminate\Support\Facades\DB;

use Illuminate\Database\Schema\Blueprint;

return new class extends Migration

{use Illuminate\Support\Facades\Schema;use Illuminate\Database\Migrations\Migration;use Illuminate\Database\Migrations\Migration;

    /**

     * Run the migrations.

     */

    public function up(): voidreturn new class extends Migrationuse Illuminate\Database\Schema\Blueprint;use Illuminate\Database\Schema\Blueprint;

    {

        // Create a temporary table{

        Schema::create('temp_program_assignments', function (Blueprint $table) {

            // Copy all columns from program_assignments    /**use Illuminate\Support\Facades\Schema;use Illuminate\Support\Facades\Schema;

            $table->id();

            $table->foreignId('client_id')->constrained('users');     * Run the migrations.

            $table->foreignId('trainer_id')->constrained('users');

            $table->foreignId('program_id')->constrained('programs');     */use Illuminate\Support\Facades\DB;use Illuminate\Support\Facades\DB;

            $table->string('status')->default('pending'); // New column with all possible values including withdrawn

            $table->timestamps();    public function up(): void

        });

            {

        // Copy data

        DB::statement('INSERT INTO temp_program_assignments SELECT * FROM program_assignments');        // Create a temporary table

        

        // Drop original table        Schema::create('temp_program_assignments', function (Blueprint $table) {return new class extends Migrationreturn new class extends Migration

        Schema::drop('program_assignments');

                    // Copy all columns from program_assignments

        // Rename temp table

        Schema::rename('temp_program_assignments', 'program_assignments');            $table->id();{{

    }

            $table->foreignId('client_id')->constrained('users');

    /**

     * Reverse the migrations.            $table->foreignId('trainer_id')->constrained('users');    /**    /**

     */

    public function down(): void            $table->foreignId('program_id')->constrained('programs');

    {

        // Create a temporary table            $table->string('status')->default('pending'); // New column with all possible values including withdrawn     * Run the migrations.     * Run the migrations.

        Schema::create('temp_program_assignments', function (Blueprint $table) {

            // Copy all columns from program_assignments            $table->timestamps();

            $table->id();

            $table->foreignId('client_id')->constrained('users');        });     */     */

            $table->foreignId('trainer_id')->constrained('users');

            $table->foreignId('program_id')->constrained('programs');        

            $table->string('status')->default('pending'); // Revert status without withdrawn

            $table->timestamps();        // Copy data    public function up(): void    public function up(): void

        });

                DB::statement('INSERT INTO temp_program_assignments SELECT * FROM program_assignments');

        // Copy data, excluding any rows with withdrawn status

        DB::statement("INSERT INTO temp_program_assignments SELECT * FROM program_assignments WHERE status != 'withdrawn'");            {    {

        

        // Drop original table        // Drop original table

        Schema::drop('program_assignments');

                Schema::drop('program_assignments');        Schema::table('program_assignments', function (Blueprint $table) {        // Add 'withdrawn' status to the ENUM column

        // Rename temp table

        Schema::rename('temp_program_assignments', 'program_assignments');        

    }

};        // Rename temp table            // SQLite doesn't support changing enum columns directly        DB::statement("ALTER TABLE program_assignments MODIFY COLUMN status ENUM('pending', 'active', 'completed', 'paused', 'cancelled', 'rejected', 'deactivated', 'pending_payment', 'withdrawn') NOT NULL DEFAULT 'pending'");

        Schema::rename('temp_program_assignments', 'program_assignments');

    }            // Instead, we'll use string with check constraint    }



    /**            DB::statement('DROP TABLE IF EXISTS program_assignments_old');

     * Reverse the migrations.

     */            DB::statement('CREATE TABLE program_assignments_old AS SELECT * FROM program_assignments');    /**

    public function down(): void

    {            DB::statement('DROP TABLE program_assignments');     * Reverse the migrations.

        // Create a temporary table

        Schema::create('temp_program_assignments', function (Blueprint $table) {                 */

            // Copy all columns from program_assignments

            $table->id();            Schema::create('program_assignments', function (Blueprint $table) {    public function down(): void

            $table->foreignId('client_id')->constrained('users');

            $table->foreignId('trainer_id')->constrained('users');                $table->id();    {

            $table->foreignId('program_id')->constrained('programs');

            $table->string('status')->default('pending'); // Revert status without withdrawn                $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');        // Remove 'withdrawn' status from the ENUM column

            $table->timestamps();

        });                $table->foreignId('trainer_id')->constrained('trainers')->onDelete('cascade');        DB::statement("ALTER TABLE program_assignments MODIFY COLUMN status ENUM('pending', 'active', 'completed', 'paused', 'cancelled', 'rejected', 'deactivated', 'pending_payment') NOT NULL DEFAULT 'pending'");

        

        // Copy data, excluding any rows with withdrawn status                $table->foreignId('program_id')->nullable()->constrained('programs')->onDelete('set null');    }

        DB::statement("INSERT INTO temp_program_assignments SELECT * FROM program_assignments WHERE status != 'withdrawn'");

                        $table->string('status')->default('pending');};

        // Drop original table

        Schema::drop('program_assignments');                $table->timestamps();

                    });

        // Rename temp table

        Schema::rename('temp_program_assignments', 'program_assignments');            DB::statement("INSERT INTO program_assignments SELECT * FROM program_assignments_old");

    }            DB::statement('DROP TABLE program_assignments_old');

};            DB::statement("CREATE INDEX program_assignments_status_index ON program_assignments (status)");
            DB::statement("CREATE TABLE IF NOT EXISTS sqlite_schema (type TEXT,name TEXT,tbl_name TEXT,rootpage INTEGER,sql TEXT)");
            DB::statement("INSERT INTO sqlite_schema (type, name, tbl_name, rootpage, sql) VALUES ('table', 'program_assignments_status_check', 'program_assignments', NULL, 'CREATE TABLE program_assignments_status_check (status TEXT CHECK (status IN (''pending'', ''active'', ''completed'', ''paused'', ''cancelled'', ''rejected'', ''deactivated'', ''pending_payment'', ''withdrawn'')))');");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('program_assignments', function (Blueprint $table) {
            DB::statement('DROP TABLE IF EXISTS program_assignments_old');
            DB::statement('CREATE TABLE program_assignments_old AS SELECT * FROM program_assignments');
            DB::statement('DROP TABLE program_assignments');
            
            Schema::create('program_assignments', function (Blueprint $table) {
                $table->id();
                $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
                $table->foreignId('trainer_id')->constrained('trainers')->onDelete('cascade');
                $table->foreignId('program_id')->nullable()->constrained('programs')->onDelete('set null');
                $table->string('status')->default('pending');
                $table->timestamps();
            });

            DB::statement("INSERT INTO program_assignments SELECT * FROM program_assignments_old");
            DB::statement('DROP TABLE program_assignments_old');
            DB::statement("CREATE INDEX program_assignments_status_index ON program_assignments (status)");
            DB::statement("CREATE TABLE IF NOT EXISTS sqlite_schema (type TEXT,name TEXT,tbl_name TEXT,rootpage INTEGER,sql TEXT)");
            DB::statement("INSERT INTO sqlite_schema (type, name, tbl_name, rootpage, sql) VALUES ('table', 'program_assignments_status_check', 'program_assignments', NULL, 'CREATE TABLE program_assignments_status_check (status TEXT CHECK (status IN (''pending'', ''active'', ''completed'', ''paused'', ''cancelled'', ''rejected'', ''deactivated'', ''pending_payment'')))');");
        });
    }
};