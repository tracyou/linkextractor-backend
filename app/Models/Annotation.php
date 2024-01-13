<?php

declare(strict_types=1);

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Annotation.
 *
 * @property string                          $id
 * @property string                          $matter_id
 * @property string                          $article_id
 * @property string                          $text
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string                          $relation_schema_id
 * @property-read \App\Models\Article $article
 * @property-read \App\Models\Matter $matter
 * @property-read \App\Models\RelationSchema $relationSchema
 *
 * @method static \Database\Factories\AnnotationFactory factory($count = null, $state = [])
 * @method static Builder|Annotation                    newModelQuery()
 * @method static Builder|Annotation                    newQuery()
 * @method static Builder|Annotation                    onlyTrashed()
 * @method static Builder|Annotation                    query()
 * @method static Builder|Annotation                    whereArticleId($value)
 * @method static Builder|Annotation                    whereCreatedAt($value)
 * @method static Builder|Annotation                    whereDeletedAt($value)
 * @method static Builder|Annotation                    whereId($value)
 * @method static Builder|Annotation                    whereMatterId($value)
 * @method static Builder|Annotation                    whereRelationSchemaId($value)
 * @method static Builder|Annotation                    whereText($value)
 * @method static Builder|Annotation                    whereUpdatedAt($value)
 * @method static Builder|Annotation                    withTrashed()
 * @method static Builder|Annotation                    withoutTrashed()
 *
 * @mixin Eloquent
 */
final class Annotation extends AbstractModel
{
    protected $table = 'annotations';

    protected $fillable = [
        'matter_id',
        'text',
    ];

    public function matter(): BelongsTo
    {
        return $this->belongsTo(Matter::class);
    }

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    public function relationSchema(): BelongsTo
    {
        return $this->belongsTo(RelationSchema::class);
    }
}
