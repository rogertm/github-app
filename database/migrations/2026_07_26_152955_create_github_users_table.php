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
        Schema::create('github_users', function (Blueprint $table) {
            $table->id();
            $table->string('github_login')->unique(); // Github handle
            $table->unsignedBigInteger('github_id')->unique();
            $table->string('name')->nullable();
            $table->string('html_url');
            $table->string('avatar_url');
            $table->string('location')->nullable();
            $table->text('bio')->nullable();
            $table->unsignedInteger('public_repos');
            $table->unsignedInteger('followers');
            $table->unsignedInteger('following');
            $table->string('type');
            $table->string('email')->nullable();
            $table->dateTime('github_created_at');
            $table->dateTime('github_updated_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('github_users');
    }
};
