<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Annotation;
use App\Models\Article;
use App\Models\ArticleRevision;
use App\Models\Law;
use App\Models\Matter;
use App\Models\RelationSchema;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Annotation>
 */
class AnnotationFactory extends Factory
{
    protected $model = Annotation::class;

    public function definition(): array
    {
        return [
            'matter_id'           => Matter::factory(),
            'relation_schema_id'  => RelationSchema::factory(),
            'text'                => $this->faker->sentence,
            'definition'          => $this->faker->word,
            'comment'             => $this->faker->sentence,
            'article_revision_id' => ArticleRevision::factory(),
        ];
    }
}
