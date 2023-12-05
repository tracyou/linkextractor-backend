<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Law.
 *
 * @property string                                       $id
 * @property string                                       $title
 * @property string                                       $text
 * @property bool                                         $is_published
 * @property \Illuminate\Support\Carbon|null              $created_at
 * @property \Illuminate\Support\Carbon|null              $updated_at
 * @property \Illuminate\Support\Carbon|null              $deleted_at
 * @property-read Collection<int, \App\Models\Annotation> $annotations
 * @property-read int|null                                $annotations_count
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
 * @method static \Illuminate\Database\Eloquent\Builder|Law whereText($value)
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
        'text',
        'is_published',
    ];

    public function annotations(): BelongsToMany
    {
        return $this
            ->belongsToMany(Annotation::class)
            ->withPivot([
                'cursor_index',
                'comment',
            ])
            ->using(LawAnnotationPivot::class);
    }
}
