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
        if (!Schema::hasTable('skills')) {
            return; // Skip if table doesn't exist yet
        }

        Schema::table('skills', function (Blueprint $table) {
            // Remove category if exists (not in schema)
            if (Schema::hasColumn('skills', 'category')) {
                $table->dropColumn('category');
            }
            
            // Update name length if needed
            if (Schema::hasColumn('skills', 'name')) {
                $table->string('name', 100)->unique()->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('skills', function (Blueprint $table) {
            $table->string('category')->nullable();
        });
    }
};

