<?php

use App\Http\Controllers\Dashboard\GithubUserController;
use App\Http\Controllers\Dashboard\RepositoryController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])
    ->prefix('dashboard')
    ->name('dashboard.')
    ->group(function () {
        Route::resource('github-users', GithubUserController::class)
            ->except(['create', 'edit']);

        // Route::resource('repositories', RepositoryController::class)
        //     ->except(['create', 'edit']);

        Route::resource('github-users.repositories', RepositoryController::class)
            ->shallow()
            ->except(['create', 'edit']);
    });
