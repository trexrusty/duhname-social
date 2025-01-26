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
        Schema::create('posts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('content');
            $table->foreignUuid('user_id')->constrained('users');
            $table->integer('likes_count')->default(0);
            $table->boolean('is_draft')->default(false);
            $table->boolean('is_private')->default(false);
            $table->boolean('report_count_too_much')->default(false);
            $table->boolean('cleared')->default(false);
            $table->softDeletes();
            $table->enum('post_type', ['text', 'image', 'video', 'poll'])->default('text');
            $table->integer('report_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
