<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Pancake
 *
 * @property string $id
 * @property string $title
 * @property string $text
 * @property boolean $is_published
 *
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */
final class Law extends Model
{

    protected $fillable = [
        'title',
        'text',
        'isPublished'
    ];

    public function annotations(): BelongsToMany
    {
        return $this
            ->belongsToMany(Annotation::class)
            ->withPivot('cursor_index')
            ->using(LawAnnotationPivot::class);
    }
}
