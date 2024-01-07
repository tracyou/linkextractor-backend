<?php

namespace Database\Factories;

use App\Models\Law;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Law>
 */
final class LawFactory extends Factory
{
    protected $model = Law::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title'        => $this->faker->title,
            'is_published' => $this->faker->boolean,
        ];
    }
}
