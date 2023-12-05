<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\AnnotationFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Annotation
 *
 * @property string                    $id
 * @property string                    $matter_id
 * @property string                    $text
 * @property Carbon|null               $created_at
 * @property Carbon|null               $updated_at
 * @property Carbon|null               $deleted_at
 * @property-read Collection<int, Law> $law
 * @property-read int|null             $law_count
 * @property-read Matter               $matter
 * @method static AnnotationFactory factory($count = null, $state = [])
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
final class Annotation extends AbstractModel
{
    protected $table = 'annotations';

    protected $fillable = [
        'matter_id',
        'text',
    ];

    public function matter(): BelongsTo
    {
        return $this->belongsTo(Matter::class);
    }

    //relationship with Law
    public function laws(): BelongsToMany
    {
        return $this
            ->belongsToMany(Law::class)
            ->withPivot('cursor_index')
            ->using(LawAnnotationPivot::class);
    }
}
