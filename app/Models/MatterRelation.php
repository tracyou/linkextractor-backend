<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\MatterRelationEnum;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\MatterRelation.
 *
 * @property string                                $id
 * @property string                                $related_matter_id
 * @property MatterRelationEnum                    $relation
 * @property string|null                           $description
 * @property \Illuminate\Support\Carbon|null       $created_at
 * @property \Illuminate\Support\Carbon|null       $updated_at
 * @property string|null                           $deleted_at
 * @property string                                $matter_relation_schema_id
 * @property-read \App\Models\MatterRelationSchema $matterRelationSchema
 * @property-read \App\Models\Matter               $relatedMatter
 *
 * @method static \Database\Factories\MatterRelationFactory factory($count = null, $state = [])
 * @method static Builder|MatterRelation                    newModelQuery()
 * @method static Builder|MatterRelation                    newQuery()
 * @method static Builder|MatterRelation                    query()
 * @method static Builder|MatterRelation                    whereCreatedAt($value)
 * @method static Builder|MatterRelation                    whereDeletedAt($value)
 * @method static Builder|MatterRelation                    whereDescription($value)
 * @method static Builder|MatterRelation                    whereId($value)
 * @method static Builder|MatterRelation                    whereMatterRelationSchemaId($value)
 * @method static Builder|MatterRelation                    whereRelatedMatterId($value)
 * @method static Builder|MatterRelation                    whereRelation($value)
 * @method static Builder|MatterRelation                    whereUpdatedAt($value)
 *
 * @mixin Eloquent
 */
final class MatterRelation extends Model
{
    use HasFactory;
    use HasUuids;

    protected $keyType = 'string';

    protected $table = 'matter_relations';

    public $incrementing = false;

    public $fillable = [
        'relation',
        'description',
    ];

    protected $casts = [
        'relation' => MatterRelationEnum::class,
    ];

    public function relatedMatter(): BelongsTo
    {
        return $this->belongsTo(Matter::class, 'related_matter_id', 'id');
    }

    public function matterRelationSchema(): BelongsTo
    {
        return $this->belongsTo(MatterRelationSchema::class);
    }
}
