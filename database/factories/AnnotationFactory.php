<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Annotation;
use App\Models\Article;
use App\Models\Matter;
use App\Models\RelationSchema;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Annotation>
 */
class AnnotationFactory extends Factory
{
    protected $model = Annotation::class;

    public function definition(): array
    {
        return [
            'text'               => $this->faker->sentence,
            'definition'         => $this->faker->word,
            'comment'            => $this->faker->sentence,
            'matter_id'          => Matter::factory(),
            'article_id'         => Article::factory(),
            'relation_schema_id' => RelationSchema::factory(),
        ];
    }
}
