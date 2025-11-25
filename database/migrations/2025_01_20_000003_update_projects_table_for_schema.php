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
            if (!Schema::hasColumn('projects', 'slug')) {
                $table->string('slug', 255)->unique()->after('title');
            }
            if (!Schema::hasColumn('projects', 'admin_notes')) {
                $table->text('admin_notes')->nullable()->after('status');
            }
            if (!Schema::hasColumn('projects', 'approved_by')) {
                $table->foreignId('approved_by')->nullable()->after('admin_notes')->constrained('users')->nullOnDelete();
            }
            if (!Schema::hasColumn('projects', 'approved_at')) {
                $table->timestamp('approved_at')->nullable()->after('approved_by');
            }
            if (Schema::hasColumn('projects', 'budget')) {
                $table->decimal('budget', 15, 2)->nullable()->change();
            } else {
                $table->decimal('budget', 15, 2)->nullable()->after('max_applicants');
            }
            
            // Remove selected_user_id if exists (not in schema)
            if (Schema::hasColumn('projects', 'selected_user_id')) {
                $table->dropForeign(['selected_user_id']);
                $table->dropColumn('selected_user_id');
            }
            
            // Note: brief_path is kept for backward compatibility even though not in SQL schema
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn([
                'slug',
                'admin_notes',
                'approved_by',
                'approved_at',
            ]);
        });
    }
};

