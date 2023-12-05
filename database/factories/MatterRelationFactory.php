<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\MatterRelationEnum;
use App\Models\Matter;
use App\Models\MatterRelation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MatterRelation>
 */
class MatterRelationFactory extends Factory
{
    protected $model = MatterRelation::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'matter_parent_id' => Matter::factory(),
            'matter_child_id'  => Matter::factory(),
            'relation'         => MatterRelationEnum::getRandomValue(),
            'description'      => fake()->sentence(),
        ];
    }
}
