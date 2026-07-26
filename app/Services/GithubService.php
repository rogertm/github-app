<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GithubService
{
    /**
     * @var string
     */
    public string $base_url;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->base_url = 'https://api.github.com';
    }

    /**
     * Fetch User
     *
     * @param string $username
     * @return array
     */
    public function fetchUser(string $username): array
    {
        $response = Http::get($this->base_url . '/users/' . $username);

        $response->throw();

        return $response->json();
    }

    /**
     * Fetch Repositories
     *
     * @param string $username
     * @return array
     */
    public function fetchRepositories(string $username): array
    {
        $response = Http::get($this->base_url . '/users/' . $username . '/repos');

        $response->throw();

        return $response->json();
    }
}
