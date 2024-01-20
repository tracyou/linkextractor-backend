<?php

declare(strict_types=1);

namespace Integration\Repositories;

use App\Contracts\Repositories\MatterRelationSchemaRepositoryInterface;
use App\Models\Matter;
use App\Models\MatterRelationSchema;
use App\Models\RelationSchema;
use Illuminate\Support\Collection;
use Tests\Http\GraphQL\AbstractHttpGraphQLTestCase;

class MatterRelationSchemaRepositoryTest extends AbstractHttpGraphQLTestCase
{
    public MatterRelationSchemaRepositoryInterface $repository;

    public function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->app->make(MatterRelationSchemaRepositoryInterface::class);
    }

    /**
     * @test
     */
    public function it_gets_all_matter_relation_schemas_for_given_schema_id(): void
    {
        // Arrange
        $relationSchema = RelationSchema::factory()->create([
            'id' => $this->createUUIDFromID(1),
        ]);

        Matter::factory()->createMany([
            [
                'id'   => $this->createUUIDFromID(1),
                'name' => 'matter1',
            ],
            [
                'id'   => $this->createUUIDFromID(2),
                'name' => 'matter2',
            ],
        ]);

        MatterRelationSchema::factory()->createMany([
            [
                'id'                 => $this->createUUIDFromID(1),
                'relation_schema_id' => $this->createUUIDFromID(1),
                'matter_id'          => $this->createUUIDFromID(1),
            ],
            [
                'id'                 => $this->createUUIDFromID(2),
                'relation_schema_id' => $this->createUUIDFromID(1),
                'matter_id'          => $this->createUUIDFromID(2),
            ],
        ]);

        // Act
        /** @var Collection<int, MatterRelationSchema> $result */
        $result = $this->repository->getForRelationSchema($relationSchema->id);

        // Assert
        $this->assertCount(2, $result);
        $this->assertEquals($this->createUUIDFromID(1), $result[0]->getKey());
        $this->assertEquals($this->createUUIDFromID(2), $result[1]->getKey());

        $matter1 = Matter::find($this->createUUIDFromID(1));
        $matter2 = Matter::find($this->createUUIDFromID(2));

        $this->assertCount(1, $matter1->matterRelationSchemas);
        $this->assertCount(1, $matter2->matterRelationSchemas);
    }

    /**
     * @test
     */
    public function it_gets_matter_relation_schema_for_given_relation_schema_id_and_matter_id(): void
    {
        // Arrange
        $relationSchema = RelationSchema::factory()->create([
            'id' => $this->createUUIDFromID(1),
        ]);

        $matter = Matter::factory()->create([
            'id' => $this->createUUIDFromID(1),
        ]);

        MatterRelationSchema::factory()->create([
            'id'                 => $this->createUUIDFromID(1),
            'relation_schema_id' => $this->createUUIDFromID(1),
            'matter_id'          => $this->createUUIDFromID(1),
        ]);

        // Act
        $result = $this->repository->getMatterRelationSchema($relationSchema->getKey(), $matter->getKey());

        // Assert
        $this->assertInstanceOf(MatterRelationSchema::class, $result);
        $this->assertEquals($this->createUUIDFromID(1), $result->getKey());
    }
}
