<?php

namespace App\Console\Commands;

use App\Models\GithubUser;
use App\Services\GithubImportService;
use App\Services\GithubService;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('github:import {username : The GitHub username to import}')]
#[Description('Import (or update) a GitHub user and their repositories')]
class ImportGithubRepositories extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(GithubService $githubService, GithubImportService $importService): int
    {
        $username = $this->argument('username');

        $this->info("Looking for the GitHub user: {$username}...");

        $userData = $githubService->fetchUser($username);

        $githubUser = GithubUser::updateOrCreate(
            [
                'github_id' => $userData['id'],
            ],
            [
                'github_login'        => $userData['login'] ?? null,
                'name'                => $userData['name'] ?? null,
                'html_url'            => $userData['html_url'] ?? null,
                'avatar_url'          => $userData['avatar_url'],
                'location'            => $userData['location'] ?? null,
                'bio'                 => $userData['bio'] ?? null,
                'public_repos'        => $userData['public_repos'],
                'followers'           => $userData['followers'],
                'following'           => $userData['following'],
                'type'                => $userData['type'],
                'email'               => $userData['email'] ?? null,
                'github_created_at'   => $userData['created_at'],
                'github_updated_at'   => $userData['updated_at'],
            ]
        );

        $this->info("User found/created: {$githubUser->github_login} (id: {$githubUser->id})");
        $this->info('Importing repositories...');

        $count = $importService->importForUser($githubUser);

        $this->info("Done! {$count} repositories were processed.");

        return self::SUCCESS;
    }
}
