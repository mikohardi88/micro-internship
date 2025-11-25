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
        if (!Schema::hasTable('deliverables')) {
            return; // Skip if table doesn't exist yet
        }

        Schema::table('deliverables', function (Blueprint $table) {
            // Remove submitted_by if exists (not in schema)
            if (Schema::hasColumn('deliverables', 'submitted_by')) {
                $table->dropForeign(['submitted_by']);
                $table->dropColumn('submitted_by');
            }
            
            // Update status enum
            if (Schema::hasColumn('deliverables', 'status')) {
                $table->enum('status', ['submitted', 'under_review', 'revision_requested', 'accepted', 'rejected'])->default('submitted')->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('deliverables', function (Blueprint $table) {
            $table->foreignId('submitted_by')->nullable()->constrained('users')->cascadeOnDelete();
        });
    }
};

