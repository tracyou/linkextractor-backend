<?php

declare(strict_types=1);

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\PancakeStack.
 *
 * @property int                             $id
 * @property string                          $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Pancake> $pancakes
 * @property-read int|null $pancakes_count
 *
 * @method static \Database\Factories\PancakeStackFactory            factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|PancakeStack newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PancakeStack newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PancakeStack onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|PancakeStack query()
 * @method static \Illuminate\Database\Eloquent\Builder|PancakeStack whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PancakeStack whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PancakeStack whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PancakeStack whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PancakeStack whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PancakeStack withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|PancakeStack withoutTrashed()
 *
 * @mixin \Eloquent
 */
final class PancakeStack extends Model
{
    use HasFactory;
    use SoftDeletes;

    private static int $MAX_PANCAKES = 25;

    /** @var string[] */
    protected $fillable = [
        'name',
    ];

    /** @param array<string, mixed> $attributes */
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

    /** @throws Exception */
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
