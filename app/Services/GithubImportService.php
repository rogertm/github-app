<?php

namespace App\Services;

use App\Models\GithubUser;
use App\Models\Repository;

class GithubImportService
{
    /**
     * Create a new service instance.
     */
    public function __construct(
        protected GithubService $githubService
    ) {}

    /**
     * Import (or update) all repositories for the given GitHub user.
     *
     * New repositories are created with is_visible = false by default
     * (see the column default in the migration), so existing repos that
     * were manually toggled on/off are never overwritten on re-import.
     *
     * @return int Number of repositories processed.
     */
    public function importForUser(GithubUser $githubUser): int
    {
        $repos = $this->githubService->fetchRepositories($githubUser->github_login);

        $importedCount = 0;

        foreach ($repos as $repoData) {
            Repository::updateOrCreate(
                [
                    'github_repo_id' => $repoData['id'],
                ],
                [
                    'github_user_id'    => $githubUser->id,
                    'name'              => $repoData['name'],
                    'html_url'          => $userData['html_url'] ?? null,
                    'full_name'         => $repoData['full_name'],
                    'description'       => $repoData['description'] ?? null,
                    'git_url'           => $repoData['git_url'],
                    'ssh_url'           => $repoData['ssh_url'],
                    'homepage'          => $repoData['homepage'] ?? null,
                    'size'              => $repoData['size'] ?? 0,
                    'latest_tag'        => [], // TODO: resolver en fase de import de tags
                    'language'          => $repoData['language'] ?? null,
                    'license_key'       => $repoData['license']['key'] ?? null,
                    'license_name'      => $repoData['license']['name'] ?? null,
                    'topics'            => $repoData['topics'] ?? [],
                    'github_created_at' => $repoData['created_at'],
                    'github_updated_at' => $repoData['updated_at'],
                    'github_pushed_at'  => $repoData['pushed_at'],
                    // is_visible NO se toca aquí a propósito: el default
                    // de la columna (false) se aplica solo al crear, y
                    // así no pisamos el valor si el usuario ya lo activó.
                ]
            );

            $importedCount++;
        }

        return $importedCount;
    }
}
