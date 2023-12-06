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
 * @property-read Collection<int, \App\Models\Annotation> $annotations
 * @property-read int|null $annotations_count
 * @property-read Collection<int, \App\Models\MatterRelation> $matterRelationsParents
 * @property-read int|null $matter_relations_a_count
 * @property-read Collection<int, \App\Models\MatterRelation> $matterRelationsChilds
 * @property-read int|null $matter_relations_b_count
 * @method static \Database\Factories\MatterFactory factory($count = null, $state = [])
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
class Matter extends AbstractModel
{
    protected $table = 'matters';
    protected $fillable = [
        'name',
        'color'
    ];
    public function annotations(): HasMany
    {
        return $this->hasMany(Annotation::class);
    }

    public function matterRelationsParents(): HasMany
    {
        return $this->hasMany(MatterRelation::class, 'matter_a_id');
    }

    public function matterRelationsChilds(): HasMany
    {
        return $this->hasMany(MatterRelation::class, 'matter_b_id');
    }
}
