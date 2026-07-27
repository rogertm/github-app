<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $github_user_id
 * @property int $github_repo_id
 * @property string $name
 * @property string $full_name
 * @property string|null $description
 * @property string $git_url
 * @property string $ssh_url
 * @property string|null $homepage
 * @property int $size
 * @property array $latest_tag
 * @property string|null $language
 * @property string|null $license_key
 * @property string|null $license_name
 * @property array $topics
 * @property Carbon $github_created_at
 * @property Carbon $github_updated_at
 * @property Carbon $github_pushed_at
 * @property bool $is_visible
 * @property int $sort_order
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable([
    'github_user_id',
    'github_repo_id',
    'name',
    'full_name',
    'html_url',
    'description',
    'git_url',
    'ssh_url',
    'homepage',
    'size',
    'latest_tag',
    'language',
    'license_key',
    'license_name',
    'topics',
    'github_created_at',
    'github_updated_at',
    'github_pushed_at',
    'is_visible',
    'sort_order',
])]
class Repository extends Model
{
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'latest_tag' => 'array',
            'topics' => 'array',
            'is_visible' => 'boolean',
            'github_created_at' => 'datetime',
            'github_updated_at' => 'datetime',
            'github_pushed_at' => 'datetime',
        ];
    }

    /**
     * Get the GitHub user that owns the repository.
     *
     * @return BelongsTo<GithubUser, $this>
     */
    public function githubUser(): BelongsTo
    {
        return $this->belongsTo(GithubUser::class);
    }
}
