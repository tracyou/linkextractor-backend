<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\MatterRelation
 *
 * @property string $matter_a_id
 * @property string $matter_b_id
 * @property string $relation
 * @property string $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Matter $matterA
 * @property-read Matter $matterB
 * @method static Builder|MatterRelation newModelQuery()
 * @method static Builder|MatterRelation newQuery()
 * @method static Builder|MatterRelation onlyTrashed()
 * @method static Builder|MatterRelation query()
 * @method static Builder|MatterRelation whereCreatedAt($value)
 * @method static Builder|MatterRelation whereDeletedAt($value)
 * @method static Builder|MatterRelation whereDescription($value)
 * @method static Builder|MatterRelation whereMatterAId($value)
 * @method static Builder|MatterRelation whereMatterBId($value)
 * @method static Builder|MatterRelation whereRelation($value)
 * @method static Builder|MatterRelation whereUpdatedAt($value)
 * @method static Builder|MatterRelation withTrashed()
 * @method static Builder|MatterRelation withoutTrashed()
 * @mixin Eloquent
 */
final class MatterRelation extends Model
{
    protected $table = 'matter_relations';
    public $incrementing = false;

    public function matterA(): BelongsTo
    {
        return $this->belongsTo(Matter::class, 'matter_a_id', 'id');
    }

    public function matterB(): BelongsTo
    {
        return $this->belongsTo(Matter::class, 'matter_b_id', 'id');
    }
}
