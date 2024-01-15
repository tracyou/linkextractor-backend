<?php

declare(strict_types=1);

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\RelationSchema.
 *
 * @property string                          $id
 * @property bool                            $is_published
 * @property \Illuminate\Support\Carbon|null $expired_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Annotation> $annotations
 * @property-read int|null $annotations_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MatterRelationSchema> $matterRelationSchemas
 * @property-read int|null $matter_relation_schemas_count
 *
 * @method static \Database\Factories\RelationSchemaFactory factory($count = null, $state = [])
 * @method static Builder|RelationSchema                    newModelQuery()
 * @method static Builder|RelationSchema                    newQuery()
 * @method static Builder|RelationSchema                    onlyTrashed()
 * @method static Builder|RelationSchema                    query()
 * @method static Builder|RelationSchema                    whereCreatedAt($value)
 * @method static Builder|RelationSchema                    whereDeletedAt($value)
 * @method static Builder|RelationSchema                    whereExpiredAt($value)
 * @method static Builder|RelationSchema                    whereId($value)
 * @method static Builder|RelationSchema                    whereIsPublished($value)
 * @method static Builder|RelationSchema                    whereUpdatedAt($value)
 * @method static Builder|RelationSchema                    withTrashed()
 * @method static Builder|RelationSchema                    withoutTrashed()
 *
 * @mixin Eloquent
 */
final class RelationSchema extends AbstractModel
{
    protected $table = 'relation_schemas';

    public $incrementing = false;

    public $fillable = [
        'is_published',
        'expired_at',
    ];

    protected $casts = [
        'expired_at' => 'datetime',
    ];

    public function matterRelationSchemas(): HasMany
    {
        return $this->hasMany(MatterRelationSchema::class);
    }

    public function annotations(): HasMany
    {
        return $this->hasMany(Annotation::class);
    }
}
