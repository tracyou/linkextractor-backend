<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Matter;
use App\Models\MatterRelationSchema;
use App\Models\RelationSchema;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MatterRelationSchema>
 */
class MatterRelationSchemaFactory extends Factory
{
    protected $model = MatterRelationSchema::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'matter_id'          => Matter::factory(),
            'schema_layout'      => '{"type":"object","properties":{"name":{"type":"string"}}}',
            'relation_schema_id' => RelationSchema::factory(),
        ];
    }
}
