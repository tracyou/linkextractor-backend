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
 * @property string $id
 * @property string $law_id
 * @property string $annotation_id
 * @property int $cursor_index
 * @property-read Annotation $annotation
 * @property-read Law $law
 *
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
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
