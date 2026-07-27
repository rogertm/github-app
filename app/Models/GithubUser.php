<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $github_login
 * @property int $github_id
 * @property string|null $name
 * @property string $html_url
 * @property string $avatar_url
 * @property string|null $location
 * @property string|null $bio
 * @property int $public_repos
 * @property int $followers
 * @property int $following
 * @property string $type
 * @property string|null $email
 * @property Carbon $github_created_at
 * @property Carbon $github_updated_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable([
    'github_login',
    'github_id',
    'name',
    'html_url',
    'avatar_url',
    'location',
    'bio',
    'public_repos',
    'followers',
    'following',
    'type',
    'email',
    'github_created_at',
    'github_updated_at',
])]
class GithubUser extends Model
{

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'github_created_at' => 'datetime',
            'github_updated_at' => 'datetime',
        ];
    }

    /**
     * Get the repositories belonging to the GitHub user.
     *
     * @return HasMany<Repository>
     */
    public function repositories(): HasMany
    {
        return $this->hasMany(Repository::class);
    }
}
