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
        if (!Schema::hasTable('project_applications')) {
            return; // Skip if table doesn't exist yet
        }

        Schema::table('project_applications', function (Blueprint $table) {
            // Remove cv_path if exists (not in schema)
            if (Schema::hasColumn('project_applications', 'cv_path')) {
                $table->dropColumn('cv_path');
            }
            
            // Rename decision_note to decision_notes if needed
            if (Schema::hasColumn('project_applications', 'decision_note') && !Schema::hasColumn('project_applications', 'decision_notes')) {
                $table->renameColumn('decision_note', 'decision_notes');
            } elseif (!Schema::hasColumn('project_applications', 'decision_notes')) {
                $table->text('decision_notes')->nullable()->after('decided_at');
            }
            
            // Update status enum if needed
            if (Schema::hasColumn('project_applications', 'status')) {
                $table->enum('status', ['pending', 'shortlisted', 'accepted', 'rejected', 'withdrawn'])->default('pending')->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('project_applications', function (Blueprint $table) {
            if (Schema::hasColumn('project_applications', 'decision_notes')) {
                $table->renameColumn('decision_notes', 'decision_note');
            }
        });
    }
};

