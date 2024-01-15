<?php

declare(strict_types=1);

namespace Integration\Repositories;

use App\Contracts\Repositories\RelationSchemaRepositoryInterface;
use App\Models\RelationSchema;
use Carbon\Carbon;
use Tests\Http\GraphQL\AbstractHttpGraphQLTestCase;

class RelationSchemaRepositoryTest extends AbstractHttpGraphQLTestCase
{
    public RelationSchemaRepositoryInterface $repository;

    public function setUp(): void
    {
        parent::setUp();

        Carbon::setTestNow('2021-01-01 00:00:00');

        $this->repository = $this->app->make(RelationSchemaRepositoryInterface::class);
    }

    /**
     * @test
     */
    public function it_can_expire_all_except_given_id(): void
    {
        // Arrange
        RelationSchema::factory()->create([
            'id'           => $this->createUUIDFromID(1),
            'is_published' => true,
            'expired_at'   => '2021-01-01 00:00:00',
        ]);

        RelationSchema::factory()->create([
            'id'           => $this->createUUIDFromID(2),
            'is_published' => true,
            'expired_at'   => null,
        ]);

        RelationSchema::factory()->create([
            'id'           => $this->createUUIDFromID(3),
            'is_published' => true,
            'expired_at'   => null,
        ]);

        // Act
        $this->repository->expireAllExcept($this->createUUIDFromID(3));

        // Assert
        $this->assertDatabaseHas('relation_schemas', [
            'id'         => $this->createUUIDFromID(1),
            'expired_at' => now(),
        ]);

        $this->assertDatabaseHas('relation_schemas', [
            'id'         => $this->createUUIDFromID(2),
            'expired_at' => now(),
        ]);

        $this->assertDatabaseHas('relation_schemas', [
            'id'         => $this->createUUIDFromID(3),
            'expired_at' => null,
        ]);
    }

    /**
     * @test
     */
    public function it_returns_the_most_recent_relation_schema(): void
    {
        // Arrange
        RelationSchema::factory()->create([
            'id'           => $this->createUUIDFromID(1),
            'created_at'   => '2020-12-31 00:00:00',
            'is_published' => true,
            'expired_at'   => '2021-01-01 00:00:00',
        ]);

        RelationSchema::factory()->create([
            'id'           => $this->createUUIDFromID(2),
            'created_at'   => '2020-12-30 00:00:00',
            'is_published' => true,
            'expired_at'   => null,
        ]);

        RelationSchema::factory()->create([
            'id'           => $this->createUUIDFromID(3),
            'created_at'   => '2021-01-01 00:00:00',
            'is_published' => true,
            'expired_at'   => null,
        ]);

        // Act
        $schema = $this->repository->getMostRecent();

        // Assert
        $this->assertEquals($this->createUUIDFromID(3), $schema->id);
    }
}
