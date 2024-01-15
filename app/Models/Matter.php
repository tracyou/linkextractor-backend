<?php

declare(strict_types=1);

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

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
 * @property-read Collection<int, \App\Models\MatterRelationSchema> $matterRelationSchemas
 * @property-read int|null $matter_relation_schemas_count
 * @property-read Collection<int, \App\Models\MatterRelation> $matterRelations
 * @property-read int|null $matter_relations_count
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

    public function matterRelationSchemas(): HasMany
    {
        return $this->hasMany(MatterRelationSchema::class);
    }

    public function matterRelations(): HasManyThrough
    {
        return $this->hasManyThrough(MatterRelation::class, MatterRelationSchema::class);
    }
}
