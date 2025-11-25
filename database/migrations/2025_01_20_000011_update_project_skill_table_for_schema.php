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
        if (!Schema::hasTable('project_skill')) {
            return; // Skip if table doesn't exist yet
        }

        Schema::table('project_skill', function (Blueprint $table) {
            // Remove id column if exists (schema uses composite primary key)
            if (Schema::hasColumn('project_skill', 'id')) {
                $table->dropColumn('id');
            }
            
            // Update proficiency_level to enum
            if (Schema::hasColumn('project_skill', 'proficiency_level')) {
                $table->dropColumn('proficiency_level');
                $table->enum('proficiency_level', ['beginner', 'intermediate', 'advanced'])->default('beginner')->after('skill_id');
            }
            
            // Ensure composite primary key
            $indexes = Schema::getConnection()->getDoctrineSchemaManager()->listTableIndexes('project_skill');
            if (!isset($indexes['PRIMARY']) || count($indexes['PRIMARY']->getColumns()) !== 2) {
                $table->dropPrimary();
                $table->primary(['project_id', 'skill_id']);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('project_skill', function (Blueprint $table) {
            $table->id()->first();
            $table->dropPrimary();
            $table->unsignedTinyInteger('proficiency_level')->nullable()->change();
        });
    }
};

