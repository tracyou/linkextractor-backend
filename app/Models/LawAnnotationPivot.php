<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\Models\LawAnnotationPivot.
 *
 * @property string                                       $cursor_index
 * @property string                                       $comment
 *
 * @property-read Collection<int, \App\Models\Annotation> $annotations
 * @property-read int|null                                $annotations_count
 * @property-read Collection<int, \App\Models\Law>        $laws
 * @property-read int|null                                $laws_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|LawAnnotationPivot newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LawAnnotationPivot newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LawAnnotationPivot query()
 *
 * @mixin \Eloquent
 */
final class LawAnnotationPivot extends Pivot
{
    protected $fillable = [
        'cursor_index',
        'comment',
    ];
}
