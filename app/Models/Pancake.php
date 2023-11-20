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
 *
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property-read PancakeStack $stack
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
