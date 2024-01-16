<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\ArticleRevisionFactory;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string       $id
 * @property int          $revision
 * @property array | null $json_text
 * @property Article      $article
 * @method static ArticleRevisionFactory factory($count = null, $state = [])
 */
class ArticleRevision extends AbstractModel
{
    protected $fillable = [
        'revision',
        'json_text',
    ];

    protected $casts = [
        'json_text' => 'json',
    ];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    public function annotations(): HasMany
    {
        return $this->hasMany(Annotation::class);
    }
}
