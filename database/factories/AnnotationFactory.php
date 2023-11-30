<?php

namespace Database\Factories;

use App\Models\Annotation;
use App\Models\Matter;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Annotation>
 */
class AnnotationFactory extends Factory
{
    protected $model = Annotation::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'matter' => Matter::factory(),
            'text' => fake()->realText()
        ];
    }
}
