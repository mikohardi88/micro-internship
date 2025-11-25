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
        if (!Schema::hasTable('certificates')) {
            return; // Skip if table doesn't exist yet
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
                $table->string('certificate_number', 50)->unique()->change();
            }
        });
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

