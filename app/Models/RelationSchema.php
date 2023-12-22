<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\MatterRelationEnum;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * App\Models\RelationSchema.
 *
 * @property string                                                 $id
 * @property bool                                                   $is_published
 * @property \Illuminate\Support\Carbon|null                        $expired_at
 * @property \Illuminate\Support\Carbon|null                        $created_at
 * @property \Illuminate\Support\Carbon|null                        $updated_at
 * @property \Illuminate\Support\Carbon|null                        $deleted_at
 * @property-read Collection<int, \App\Models\MatterRelationSchema> $matterRelationSchemas
 * @property-read Collection<int, \App\Models\Annotation>           $annotations
 *
 * @method static \Database\Factories\RelationSchemaFactory factory($count = null, $state = [])
 * @method static Builder|MatterRelationSchema                    newModelQuery()
 * @method static Builder|MatterRelationSchema                    newQuery()
 * @method static Builder|MatterRelationSchema                    onlyTrashed()
 * @method static Builder|MatterRelationSchema                    query()
 * @method static Builder|MatterRelationSchema                    whereCreatedAt($value)
 * @method static Builder|MatterRelationSchema                    whereDeletedAt($value)
 * @method static Builder|MatterRelationSchema                    whereDescription($value)
 * @method static Builder|MatterRelationSchema                    whereId($value)
 * @method static Builder|MatterRelationSchema                    whereMatterChildId($value)
 * @method static Builder|MatterRelationSchema                    whereMatterParentId($value)
 * @method static Builder|MatterRelationSchema                    whereRelation($value)
 * @method static Builder|MatterRelationSchema                    whereUpdatedAt($value)
 * @method static Builder|MatterRelationSchema                    withTrashed()
 * @method static Builder|MatterRelationSchema                    withoutTrashed()
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
