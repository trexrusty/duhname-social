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
        Schema::create('reports', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users');
            $table->foreignUuid('post_id')->nullable()->constrained('posts');
            $table->foreignUuid('comment_id')->nullable()->constrained('comments');
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['post_id', 'user_id']);
            $table->unique(['comment_id', 'user_id']);
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
