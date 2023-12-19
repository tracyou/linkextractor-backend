<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Article.
 *
 * @property string                          $id
 * @property string                          $law_id
 * @property string                          $title
 * @property string                          $text
 * @property string|null                     $json_text
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read Collection<int, \App\Models\Annotation> $annotations
 * @property-read int|null $annotations_count
 * @property-read \App\Models\Law $law
 *
 * @method static \Database\Factories\ArticleFactory factory($count = null, $state = [])
 * @method static Builder|Article                    findDuplicated(string $title, string $lawId)
 * @method static Builder|Article                    newModelQuery()
 * @method static Builder|Article                    newQuery()
 * @method static Builder|Article                    onlyTrashed()
 * @method static Builder|Article                    query()
 * @method static Builder|Article                    whereCreatedAt($value)
 * @method static Builder|Article                    whereDeletedAt($value)
 * @method static Builder|Article                    whereId($value)
 * @method static Builder|Article                    whereLawId($value)
 * @method static Builder|Article                    whereText($value)
 * @method static Builder|Article                    whereTitle($value)
 * @method static Builder|Article                    whereUpdatedAt($value)
 * @method static Builder|Article                    withTrashed()
 * @method static Builder|Article                    withoutTrashed()
 *
 * @mixin \Eloquent
 */
final class Article extends AbstractModel
{
    protected $fillable = [
        'title',
        'text',
        'json_text',
    ];

    public function law(): BelongsTo
    {
        return $this->belongsTo(Law::class);
    }

    public function annotations(): HasMany
    {
        return $this->hasMany(Annotation::class);
    }

    public function scopeFindDuplicated(Builder $query, string $title, string $lawId): Builder
    {
        return $query->where('title', $title)->where('law_id', $lawId);
    }
}
