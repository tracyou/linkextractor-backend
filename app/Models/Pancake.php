<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * App\Models\Pancake
 *
 * @property int $id
 * @property int $diameter
 * @property int|null $pancake_stack_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\PancakeStack|null $stack
 * @method static \Database\Factories\PancakeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Pancake newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pancake newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pancake onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Pancake query()
 * @method static \Illuminate\Database\Eloquent\Builder|Pancake whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pancake whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pancake whereDiameter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pancake whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pancake wherePancakeStackId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pancake whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pancake withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Pancake withoutTrashed()
 * @mixin \Eloquent
 */
class Pancake extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * @var string[]
     */
    protected $fillable = [
        'diameter',
    ];

    /**
     * @param array<string, mixed> $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    // ------------------------------------------------------------------------------
    //      Relationships
    // ------------------------------------------------------------------------------

    public function stack(): BelongsTo
    {
        return $this->belongsTo(PancakeStack::class, 'pancake_stack_id');
    }

    // ------------------------------------------------------------------------------
    //      Methods
    // ------------------------------------------------------------------------------

    /**
     * @throws Exception
     */
    public function removeFromStack(): void
    {
        if ($this->stack === null) {
            throw new Exception('Pancake is not in a stack');
        }

        if ($this->stack->count() == 1) {
            throw new Exception('Pancake stack must have at least one pancake');
        }

        $this->stack()->dissociate();
        $this->save();
    }

}
