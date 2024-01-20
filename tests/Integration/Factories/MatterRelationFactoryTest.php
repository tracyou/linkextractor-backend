<?php

declare(strict_types=1);

namespace Integration\Factories;

use App\Contracts\Factories\MatterRelationFactoryInterface;
use App\Enums\MatterRelationEnum;
use App\Models\Matter;
use App\Models\MatterRelationSchema;
use Illuminate\Support\Collection;
use Tests\Http\GraphQL\AbstractHttpGraphQLTestCase;

class MatterRelationFactoryTest extends AbstractHttpGraphQLTestCase
{
    public MatterRelationFactoryInterface $matterRelationFactory;

    public function setUp(): void
    {
        parent::setUp();

        // Arrange (injection)
        $this->matterRelationFactory = $this->app->make(MatterRelationFactoryInterface::class);
    }

    public function testRelationBelongsToMatters()
    {
        // Arrange
        /** @var Collection<int, Matter> $matters */
        $matters = Matter::factory()->createMany([
            [
                'id' => $this->createUUIDFromID(1),
            ],
            [
                'id' => $this->createUUIDFromID(2),
            ],
        ]);

        $matterRelationSchema = MatterRelationSchema::factory()->create([
            'matter_id' => $matters[0]->id,
        ]);

        // Act
        $this->matterRelationFactory->create(
            $matters[1],
            $matterRelationSchema,
            MatterRelationEnum::REQUIRES_ONE(),
            "description",
        );

        // Assert
        $this->assertDatabaseHas('matter_relations', [
            'related_matter_id'         => $matters[1]->id,
            'matter_relation_schema_id' => $matterRelationSchema->id,
            'relation'                  => MatterRelationEnum::REQUIRES_ONE(),
            'description'               => "description",
        ]);

        $this->assertEquals(1, $matters[0]->matterRelations()->count());
    }
}
