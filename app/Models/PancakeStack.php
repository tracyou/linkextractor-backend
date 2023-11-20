<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * App\Models\PancakeStack
 *
 * @property int $id
 * @property string $name
 *
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property-read Collection<int, Pancake> $pancakes
 */
class PancakeStack extends Model
{
    use HasFactory;
    use SoftDeletes;

    private static int $MAX_PANCAKES = 25;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
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

    public function pancakes(): HasMany
    {
        return $this->hasMany(Pancake::class);
    }

    // ------------------------------------------------------------------------------
    //      Methods
    // ------------------------------------------------------------------------------

    /**
     * @throws Exception
     */
    public function addPancake(Pancake $pancake): void
    {
        if ($this->pancakes()->count() >= self::$MAX_PANCAKES) {
            throw new Exception('Pancake stack is full');
        }

        $this->pancakes()->save($pancake);
    }

    public function clearPancakes(): void
    {
        foreach ($this->pancakes as $pancake) {
            $pancake->stack()->dissociate();
            $pancake->save();
        }
    }
}
