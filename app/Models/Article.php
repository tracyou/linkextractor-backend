<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\ArticleFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property string                           $id
 * @property string                           $title
 * @property string                           $text
 * @property Law                              $law
 * @property Collection<int, ArticleRevision> $revisions
 * @method static ArticleFactory factory($count = null, $state = [])
 * @method static Builder|Article findDuplicated(string $title, string $lawId)
 */
class Article extends AbstractModel
{
    protected $fillable = [
        'title',
        'text',
    ];

    // -----------------------------------------------------------
    //      Relationships
    // -----------------------------------------------------------

    public function law(): BelongsTo
    {
        return $this->belongsTo(Law::class);
    }

    public function revisions(): HasMany
    {
        return $this->hasMany(ArticleRevision::class);
    }

    // -----------------------------------------------------------
    //      Scopes
    // -----------------------------------------------------------

    public function scopeFindDuplicated(Builder $query, string $title, string $lawId): Builder
    {
        return $query->where('title', $title)->where('law_id', $lawId);
    }
}
