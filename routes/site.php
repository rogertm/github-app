<?php

use App\Http\Controllers\Site\GithubUserController;
use Illuminate\Support\Facades\Route;

Route::get('github-users', [GithubUserController::class, 'home'])
    ->name('site.github-users');
