<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Hashing\HashServiceProvider;
use Illuminate\Support\Carbon;

/**
 * App\Models\Annotation
 *
 * @property string $id
 * @property string $matter_id
 * @property string $text
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Matter $matter
 * @method static Builder|Annotation newModelQuery()
 * @method static Builder|Annotation newQuery()
 * @method static Builder|Annotation onlyTrashed()
 * @method static Builder|Annotation query()
 * @method static Builder|Annotation whereCreatedAt($value)
 * @method static Builder|Annotation whereDeletedAt($value)
 * @method static Builder|Annotation whereId($value)
 * @method static Builder|Annotation whereMatterId($value)
 * @method static Builder|Annotation whereText($value)
 * @method static Builder|Annotation whereUpdatedAt($value)
 * @method static Builder|Annotation withTrashed()
 * @method static Builder|Annotation withoutTrashed()
 * @mixin Eloquent
 */
final class Annotation extends Model
{
    protected $table = 'annotations';

    public function matter(): BelongsTo
    {
        return $this->belongsTo(Matter::class, 'matter_id', 'id');
    }

    //relationship with Law
    public function law(): BelongsToMany
    {
        return $this
            ->belongsToMany(Law::class)
            ->withPivot('cursor_index')
            ->using(LawAnnotation::class);
    }
}
