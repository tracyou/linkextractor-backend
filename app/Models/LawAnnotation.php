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
 * @property-read Collection<int, \App\Models\Annotation> $annotation
 * @property-read int|null $annotation_count
 * @property-read Collection<int, \App\Models\Law> $law
 * @property-read int|null $law_count
 * @method static \Illuminate\Database\Eloquent\Builder|LawAnnotation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LawAnnotation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LawAnnotation query()
 * @mixin \Eloquent
 */
final class LawAnnotation extends Pivot
{
    protected $fillable = [
        'cursor_index'
    ];

    public function annotation(): BelongsToMany
    {
        return $this->belongsToMany(Annotation::class);
    }

    public function law(): BelongsToMany
    {
        return $this
            ->belongsToMany(Law::class);
    }

}
