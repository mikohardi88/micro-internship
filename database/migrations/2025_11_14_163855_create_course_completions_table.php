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
        Schema::create('course_completions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('course_code');
            $table->string('course_title');
            $table->timestamp('completed_at')->nullable();
            $table->unsignedTinyInteger('score')->nullable();
            $table->string('certificate_url')->nullable();
            $table->timestamps();
            $table->unique(['user_id','course_code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_completions');
    }
};
