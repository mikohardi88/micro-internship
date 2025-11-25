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
        if (!Schema::hasTable('projects')) {
            return; // Skip if table doesn't exist yet
        }

        Schema::table('projects', function (Blueprint $table) {
            // Only add/modify columns if they don't exist (they might be added by update migration)
            // Skip status modification since it already exists and SQLite doesn't support enum changes well
            
            // Only add these columns if they don't exist (they might be added by update migration)
            if (!Schema::hasColumn('projects', 'admin_notes')) {
                $table->text('admin_notes')->nullable()->after('status');
            }
            if (!Schema::hasColumn('projects', 'approved_by')) {
                $table->foreignId('approved_by')->nullable()->constrained('users')->after('admin_notes');
            }
            if (!Schema::hasColumn('projects', 'approved_at')) {
                $table->timestamp('approved_at')->nullable()->after('approved_by');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['status', 'admin_notes', 'approved_by', 'approved_at']);
        });
    }
};
