<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\Models\LawAnnotationPivot
 *
 * @property string $cursor_index
 * @property string $comment
 * @method static \Illuminate\Database\Eloquent\Builder|LawAnnotationPivot newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LawAnnotationPivot newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LawAnnotationPivot query()
 * @mixin \Eloquent
 */
final class LawAnnotationPivot extends Pivot
{
    protected $fillable = [
        'cursor_index',
        'comment',
    ];
}
