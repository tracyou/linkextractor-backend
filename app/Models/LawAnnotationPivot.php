<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\PancakeStack
 *
 * @property-read Collection<int, Annotation> $annotation
 * @property-read int|null $annotation_count
 * @property-read Collection<int, Law> $law
 * @property-read int|null $law_count
 * @method static \Illuminate\Database\Eloquent\Builder|LawAnnotationPivot newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LawAnnotationPivot newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LawAnnotationPivot query()
 * @mixin \Eloquent
 */
final class LawAnnotationPivot extends Pivot
{
    protected $fillable = [
        'cursor_index'
    ];

    public function annotations(): BelongsToMany
    {
        return $this->belongsToMany(Annotation::class);
    }

    public function laws(): BelongsToMany
    {
        return $this
            ->belongsToMany(Law::class);
    }

}
