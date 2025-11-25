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
        if (!Schema::hasTable('companies')) {
            return; // Skip if table doesn't exist yet
        }

        Schema::table('companies', function (Blueprint $table) {
            if (!Schema::hasColumn('companies', 'slug')) {
                $table->string('slug', 255)->nullable()->after('name');
            }
            if (!Schema::hasColumn('companies', 'address')) {
                $table->text('address')->nullable()->after('logo_path');
            }
            if (!Schema::hasColumn('companies', 'city')) {
                $table->string('city', 100)->nullable()->after('address');
            }
            if (!Schema::hasColumn('companies', 'province')) {
                $table->string('province', 100)->nullable()->after('city');
            }
            if (!Schema::hasColumn('companies', 'postal_code')) {
                $table->string('postal_code', 10)->nullable()->after('province');
            }
            if (!Schema::hasColumn('companies', 'phone')) {
                $table->string('phone', 20)->nullable()->after('postal_code');
            }
            if (!Schema::hasColumn('companies', 'company_size')) {
                $table->enum('company_size', ['1-10', '11-50', '51-200', '201-500', '501-1000', '1000+'])->nullable()->after('phone');
            }
            if (!Schema::hasColumn('companies', 'founded_year')) {
                $table->year('founded_year')->nullable()->after('company_size');
            }
            
            // Rename size to company_size if it exists
            if (Schema::hasColumn('companies', 'size') && !Schema::hasColumn('companies', 'company_size')) {
                $table->renameColumn('size', 'company_size');
            }
        });

        // Add unique constraint on slug after table is updated
        // Note: For SQLite, we'll add unique constraint separately
        if (Schema::hasTable('companies') && Schema::hasColumn('companies', 'slug')) {
            try {
                $indexes = Schema::getConnection()->getDoctrineSchemaManager()->listTableIndexes('companies');
                $hasSlugUnique = false;
                foreach ($indexes as $index) {
                    if ($index->getColumns() === ['slug'] && $index->isUnique()) {
                        $hasSlugUnique = true;
                        break;
                    }
                }
                if (!$hasSlugUnique) {
                    Schema::table('companies', function (Blueprint $table) {
                        $table->unique('slug');
                    });
                }
            } catch (\Exception $e) {
                // If unique constraint fails, it might already exist or table structure doesn't support it
                // Continue without failing
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn([
                'slug',
                'address',
                'city',
                'province',
                'postal_code',
                'phone',
                'company_size',
                'founded_year',
            ]);
        });
    }
};

