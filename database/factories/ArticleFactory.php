<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\Law;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Article>
 */
class ArticleFactory extends Factory
{
    protected $model = Article::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title'     => $this->faker->sentence,
            'text'      => $this->faker->text,
            'law_id'    => Law::factory(),
        ];
    }
}
