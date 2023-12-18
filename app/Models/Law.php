<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Law.
 *
 * @property string                          $id
 * @property string                          $title
 * @property bool                            $is_published
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Article> $articles
 * @property-read int|null $articles_count
 *
 * @method static \Database\Factories\LawFactory            factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Law newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Law newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Law onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Law query()
 * @method static \Illuminate\Database\Eloquent\Builder|Law whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Law whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Law whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Law whereIsPublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Law whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Law whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Law withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Law withoutTrashed()
 *
 * @mixin \Eloquent
 */
final class Law extends AbstractModel
{
    protected $fillable = [
        'title',
        'is_published',
    ];

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }
}
