<?php

declare(strict_types=1);

namespace Integration\Factories;

use App\Contracts\Factories\MatterRelationSchemaFactoryInterface;
use App\Models\Matter;
use App\Models\RelationSchema;
use Tests\Http\GraphQL\AbstractHttpGraphQLTestCase;

class MatterRelationSchemaFactoryTest extends AbstractHttpGraphQLTestCase
{
    protected MatterRelationSchemaFactoryInterface $matterRelationSchemaFactory;

    public function setUp(): void
    {
        parent::setUp();

        // Arrange (injection)
        $this->matterRelationSchemaFactory = $this->app->make(MatterRelationSchemaFactoryInterface::class);
    }

    public function test_creation_of_matter_relation_schema()
    {
        // Arrange
        $matter = Matter::factory()->create([
            'id' => $this->createUUIDFromID(1),
        ]);

        $relationSchema = RelationSchema::factory()->create([
            'id' => $this->createUUIDFromID(1),
        ]);

        //Act
        $this->matterRelationSchemaFactory->create(
            matter        : $matter,
            relationSchema: $relationSchema,
            schemaLayout  : '{}'
        );

        // Assert
        $this->assertDatabaseHas('matter_relation_schemas', [
            'matter_id'          => $matter->id,
            'relation_schema_id' => $relationSchema->id,
        ]);
    }
}
