<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\MatterRelationEnum;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\MatterRelation
 *
 * @property string                  $id
 * @property string                  $matter_parent_id
 * @property string                  $matter_child_id
 * @property MatterRelationEnum      $relation
 * @property string                  $description
 * @property Carbon|null             $created_at
 * @property Carbon|null             $updated_at
 * @property Carbon|null             $deleted_at
 * @property-read \App\Models\Matter $matterParent
 * @property-read \App\Models\Matter $matterChild
 * @method static \Database\Factories\MatterRelationFactory factory($count = null, $state = [])
 * @method static Builder|MatterRelation newModelQuery()
 * @method static Builder|MatterRelation newQuery()
 * @method static Builder|MatterRelation onlyTrashed()
 * @method static Builder|MatterRelation query()
 * @method static Builder|MatterRelation whereCreatedAt($value)
 * @method static Builder|MatterRelation whereDeletedAt($value)
 * @method static Builder|MatterRelation whereDescription($value)
 * @method static Builder|MatterRelation whereId($value)
 * @method static Builder|MatterRelation whereMatterAId($value)
 * @method static Builder|MatterRelation whereMatterBId($value)
 * @method static Builder|MatterRelation whereRelation($value)
 * @method static Builder|MatterRelation whereUpdatedAt($value)
 * @method static Builder|MatterRelation withTrashed()
 * @method static Builder|MatterRelation withoutTrashed()
 * @mixin Eloquent
 */
final class MatterRelation extends AbstractModel
{
    protected $table = 'matter_relations';

    public $incrementing = false;

    public $fillable = [
        'relation',
        'description',
    ];

    protected $casts = [
        'relation' => MatterRelationEnum::class,
    ];

    public function matterParent(): BelongsTo
    {
        return $this->belongsTo(Matter::class, 'matter_parent_id', 'id');
    }

    public function matterChild(): BelongsTo
    {
        return $this->belongsTo(Matter::class, 'matter_child_id', 'id');
    }
}
