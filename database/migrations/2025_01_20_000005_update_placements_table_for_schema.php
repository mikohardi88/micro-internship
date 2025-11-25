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
        if (!Schema::hasTable('placements')) {
            return; // Skip if table doesn't exist yet
        }

        Schema::table('placements', function (Blueprint $table) {
            // Remove old timestamp columns
            if (Schema::hasColumn('placements', 'started_at')) {
                $table->dropColumn('started_at');
            }
            if (Schema::hasColumn('placements', 'submitted_at')) {
                $table->dropColumn('submitted_at');
            }
            if (Schema::hasColumn('placements', 'verified_at')) {
                $table->dropColumn('verified_at');
            }
            if (Schema::hasColumn('placements', 'completed_at')) {
                $table->dropColumn('completed_at');
            }
            
            // Add new date columns
            if (!Schema::hasColumn('placements', 'start_date')) {
                $table->date('start_date')->nullable()->after('status');
            }
            if (!Schema::hasColumn('placements', 'end_date')) {
                $table->date('end_date')->nullable()->after('start_date');
            }
            if (!Schema::hasColumn('placements', 'supervisor_name')) {
                $table->string('supervisor_name', 255)->nullable()->after('end_date');
            }
            if (!Schema::hasColumn('placements', 'supervisor_email')) {
                $table->string('supervisor_email', 255)->nullable()->after('supervisor_name');
            }
            if (!Schema::hasColumn('placements', 'supervisor_phone')) {
                $table->string('supervisor_phone', 20)->nullable()->after('supervisor_email');
            }
            
            // Update status enum
            if (Schema::hasColumn('placements', 'status')) {
                $table->enum('status', ['matched', 'in_progress', 'completed', 'terminated'])->default('matched')->change();
            }
            
            // Remove unique constraint on project_id if exists (schema allows multiple placements per project)
            $table->dropUnique(['project_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('placements', function (Blueprint $table) {
            $table->dropColumn([
                'start_date',
                'end_date',
                'supervisor_name',
                'supervisor_email',
                'supervisor_phone',
            ]);
            
            $table->timestamp('started_at')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            
            $table->unique('project_id');
        });
    }
};

