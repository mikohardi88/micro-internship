<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('certificates')) {
            return; // Skip if table doesn't exist yet
        }

        // Drop the unique index if it exists (must be done before changing column in SQLite)
        try {
            DB::statement('DROP INDEX IF EXISTS certificates_certificate_number_unique');
        } catch (\Exception $e) {
            // Index might not exist, continue
        }

        Schema::table('certificates', function (Blueprint $table) {
            // Remove verifier and meta if exists (not in schema)
            if (Schema::hasColumn('certificates', 'verifier')) {
                $table->dropColumn('verifier');
            }
            if (Schema::hasColumn('certificates', 'meta')) {
                $table->dropColumn('meta');
            }
            
            // Update certificate_number length if needed
            if (Schema::hasColumn('certificates', 'certificate_number')) {
                // Change the column length
                $table->string('certificate_number', 50)->change();
            }
        });

        // Recreate the unique index after changing the column
        try {
            DB::statement('CREATE UNIQUE INDEX IF NOT EXISTS certificates_certificate_number_unique ON certificates(certificate_number)');
        } catch (\Exception $e) {
            // If index already exists, that's fine
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('certificates', function (Blueprint $table) {
            $table->string('verifier')->default('Vinix');
            $table->json('meta')->nullable();
        });
    }
};

