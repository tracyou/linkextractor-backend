<?php

namespace Database\Factories;

use App\Models\Matter;
use App\Models\MatterRelation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MatterRelation>
 */
class MatterRelationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'matter_a_id' => Matter::factory(),
            'matter_b_id' => Matter::factory(),
            'relation' => fake()->randomElement(['requires 1', 'requires 0 or 1', 'requires 1 or more', 'requires 0 or more']),
            'description' => fake()->sentence(),
        ];
    }
}
