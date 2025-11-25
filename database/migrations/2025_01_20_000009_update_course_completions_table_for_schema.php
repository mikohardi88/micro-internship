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
        // Migration dinonaktifkan: tidak lagi mengubah struktur tabel course_completions.
        if (!Schema::hasTable('course_completions')) {
            return;
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Tidak ada perubahan yang perlu di-rollback karena migration ini dinonaktifkan.
    }
};

