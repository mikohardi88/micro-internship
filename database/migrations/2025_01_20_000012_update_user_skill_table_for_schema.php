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
        // Rename table if needed
        if (Schema::hasTable('skill_user') && !Schema::hasTable('user_skill')) {
            Schema::rename('skill_user', 'user_skill');
        }
        
        if (!Schema::hasTable('user_skill') && !Schema::hasTable('skill_user')) {
            return; // Skip if table doesn't exist yet
        }
        
        $tableName = Schema::hasTable('user_skill') ? 'user_skill' : 'skill_user';
        
        Schema::table($tableName, function (Blueprint $table) use ($tableName) {
            // Remove id column if exists (schema uses composite primary key)
            if (Schema::hasColumn($tableName, 'id')) {
                $table->dropColumn('id');
            }
            
            // Remove endorsed_by if exists (not in schema)
            if (Schema::hasColumn($tableName, 'endorsed_by')) {
                $table->dropForeign([$tableName . '_endorsed_by_foreign']);
                $table->dropColumn('endorsed_by');
            }
            
            // Update level to proficiency_level enum
            if (Schema::hasColumn($tableName, 'level')) {
                $table->dropColumn('level');
                $table->enum('proficiency_level', ['beginner', 'intermediate', 'advanced'])->default('beginner')->after('skill_id');
            } elseif (!Schema::hasColumn($tableName, 'proficiency_level')) {
                $table->enum('proficiency_level', ['beginner', 'intermediate', 'advanced'])->default('beginner')->after('skill_id');
            }
            
            // Ensure composite primary key
            $indexes = Schema::getConnection()->getDoctrineSchemaManager()->listTableIndexes($tableName);
            if (!isset($indexes['PRIMARY']) || count($indexes['PRIMARY']->getColumns()) !== 2) {
                $table->dropPrimary();
                $table->primary(['user_id', 'skill_id']);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_skill', function (Blueprint $table) {
            $table->id()->first();
            $table->dropPrimary();
            $table->unsignedTinyInteger('level')->nullable();
            $table->foreignId('endorsed_by')->nullable()->constrained('users')->nullOnDelete();
        });
        
        if (Schema::hasTable('user_skill') && !Schema::hasTable('skill_user')) {
            Schema::rename('user_skill', 'skill_user');
        }
    }
};

