<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\ArticleFactory;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;

/**
 * @property string                           $id
 * @property string                           $title
 * @property string                           $text
 * @property Law                              $law
 * @property Collection<int, ArticleRevision> $revisions
 * @method static ArticleFactory factory($count = null, $state = [])
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
    //      Methods
    // -----------------------------------------------------------

    public function getLatestRevision(): ArticleRevision | null
    {
        /** @var ArticleRevision | null */
        return $this->revisions()->latest()->first();
    }
}
