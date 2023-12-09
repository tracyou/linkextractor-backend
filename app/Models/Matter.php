<?php

declare(strict_types=1);

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Matter.
 *
 * @property string                          $id
 * @property string                          $name
 * @property string                          $color
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read Collection<int, \App\Models\Annotation> $annotations
 * @property-read int|null $annotations_count
 * @property-read Collection<int, \App\Models\MatterRelation> $matterRelationsChilds
 * @property-read int|null $matter_relations_childs_count
 * @property-read Collection<int, \App\Models\MatterRelation> $matterRelationsParents
 * @property-read int|null $matter_relations_parents_count
 *
 * @method static \Database\Factories\MatterFactory factory($count = null, $state = [])
 * @method static Builder|Matter                    newModelQuery()
 * @method static Builder|Matter                    newQuery()
 * @method static Builder|Matter                    onlyTrashed()
 * @method static Builder|Matter                    query()
 * @method static Builder|Matter                    whereColor($value)
 * @method static Builder|Matter                    whereCreatedAt($value)
 * @method static Builder|Matter                    whereDeletedAt($value)
 * @method static Builder|Matter                    whereId($value)
 * @method static Builder|Matter                    whereName($value)
 * @method static Builder|Matter                    whereUpdatedAt($value)
 * @method static Builder|Matter                    withTrashed()
 * @method static Builder|Matter                    withoutTrashed()
 *
 * @mixin Eloquent
 */
final class Matter extends AbstractModel
{
    protected $table = 'matters';
    protected $fillable = [
        'name',
        'color',
    ];
    public function annotations(): HasMany
    {
        return $this->hasMany(Annotation::class);
    }

    public function matterRelationsParents(): HasMany
    {
        return $this->hasMany(MatterRelation::class, 'matter_parent_id');
    }

    public function matterRelationsChilds(): HasMany
    {
        return $this->hasMany(MatterRelation::class, 'matter_child_id');
    }
}
