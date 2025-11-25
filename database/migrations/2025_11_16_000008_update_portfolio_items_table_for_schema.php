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
        if (!Schema::hasTable('portfolio_items')) {
            return; // Skip if table doesn't exist yet
        }

        Schema::table('portfolio_items', function (Blueprint $table) {
            // Remove verifier and verified_at if exists (not in schema)
            if (Schema::hasColumn('portfolio_items', 'verifier')) {
                $table->dropColumn('verifier');
            }
            if (Schema::hasColumn('portfolio_items', 'verified_at')) {
                $table->dropColumn('verified_at');
            }
            
            // Add featured column if not exists
            if (!Schema::hasColumn('portfolio_items', 'featured')) {
                $table->boolean('featured')->default(false)->after('visibility');
            }
            
            // Update visibility enum
            if (Schema::hasColumn('portfolio_items', 'visibility')) {
                $table->enum('visibility', ['public', 'private'])->default('public')->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('portfolio_items', function (Blueprint $table) {
            $table->dropColumn('featured');
            $table->string('verifier')->nullable()->default('Vinix');
            $table->timestamp('verified_at')->nullable();
        });
    }
};

