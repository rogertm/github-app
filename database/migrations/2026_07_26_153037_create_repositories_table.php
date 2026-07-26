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
        Schema::create('repositories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('github_user_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('github_repo_id')->unique();
            $table->string('name');
            $table->string('full_name');
            $table->text('description')->nullable();
            $table->string('git_url');
            $table->string('ssh_url');
            $table->string('homepage')->nullable();
            $table->integer('size');
            $table->json('latest_tag'); // https://api.github.com/repos/<owner>/<repo>/tags[0]
            $table->string('language')->nullable();
            $table->string('license_key')->nullable(); // license->key
            $table->string('license_name')->nullable(); // license->name
            $table->json('topics');
            $table->dateTime('github_created_at');
            $table->dateTime('github_updated_at');
            $table->dateTime('github_pushed_at');
            $table->boolean('is_visible');
            $table->integer('sort_order');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repositories');
    }
};
