<?php

declare(strict_types=1);

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\MatterRelationSchema.
 *
 * @property string                          $id
 * @property string                          $matter_id
 * @property string                          $relation_schema_id
 * @property mixed                           $schema_layout
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Matter $matter
 * @property-read \App\Models\RelationSchema $relationSchema
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MatterRelation> $relations
 * @property-read int|null $relations_count
 *
 * @method static \Database\Factories\MatterRelationSchemaFactory factory($count = null, $state = [])
 * @method static Builder|MatterRelationSchema                    newModelQuery()
 * @method static Builder|MatterRelationSchema                    newQuery()
 * @method static Builder|MatterRelationSchema                    onlyTrashed()
 * @method static Builder|MatterRelationSchema                    query()
 * @method static Builder|MatterRelationSchema                    whereCreatedAt($value)
 * @method static Builder|MatterRelationSchema                    whereDeletedAt($value)
 * @method static Builder|MatterRelationSchema                    whereId($value)
 * @method static Builder|MatterRelationSchema                    whereMatterId($value)
 * @method static Builder|MatterRelationSchema                    whereRelationSchemaId($value)
 * @method static Builder|MatterRelationSchema                    whereSchemaLayout($value)
 * @method static Builder|MatterRelationSchema                    whereUpdatedAt($value)
 * @method static Builder|MatterRelationSchema                    withTrashed()
 * @method static Builder|MatterRelationSchema                    withoutTrashed()
 *
 * @mixin Eloquent
 */
final class MatterRelationSchema extends AbstractModel
{
    protected $table = 'matter_relation_schemas';

    public $incrementing = false;

    public $fillable = [
        'schema_layout',
    ];

    public function matter(): BelongsTo
    {
        return $this->belongsTo(Matter::class);
    }

    public function relationSchema(): BelongsTo
    {
        return $this->belongsTo(RelationSchema::class);
    }

    public function relations(): HasMany
    {
        return $this->hasMany(MatterRelation::class);
    }
}
