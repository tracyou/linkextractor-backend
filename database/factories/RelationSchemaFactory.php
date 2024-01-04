<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\MatterRelationSchema;
use App\Models\RelationSchema;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MatterRelationSchema>
 */
class RelationSchemaFactory extends Factory
{
    protected $model = RelationSchema::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'is_published' => true,
            'expired_at' => $this->faker->dateTimeBetween('-1 year'),
        ];
    }
}
