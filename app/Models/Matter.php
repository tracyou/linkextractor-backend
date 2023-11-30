<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Matter
 *
 * @property string $id
 * @property string $name
 * @property string $color
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Collection<int, Annotation> $annotations
 * @property-read int|null $annotations_count
 * @method static Builder|Matter newModelQuery()
 * @method static Builder|Matter newQuery()
 * @method static Builder|Matter onlyTrashed()
 * @method static Builder|Matter query()
 * @method static Builder|Matter whereColor($value)
 * @method static Builder|Matter whereCreatedAt($value)
 * @method static Builder|Matter whereDeletedAt($value)
 * @method static Builder|Matter whereId($value)
 * @method static Builder|Matter whereName($value)
 * @method static Builder|Matter whereUpdatedAt($value)
 * @method static Builder|Matter withTrashed()
 * @method static Builder|Matter withoutTrashed()
 * @mixin Eloquent
 */
class Matter extends Model
{
    protected $table = 'matters';

    public function annotations(): HasMany
    {
        return $this->hasMany(Annotation::class, 'matter_id', 'id');
    }

    public function matterRelationsA(): HasMany
    {
        return $this->hasMany(MatterRelation::class, 'class_a_id', 'id');
    }

    public function matterRelationsB(): HasMany
    {
        return $this->hasMany(MatterRelation::class, 'class_b_id', 'id');
    }
}
