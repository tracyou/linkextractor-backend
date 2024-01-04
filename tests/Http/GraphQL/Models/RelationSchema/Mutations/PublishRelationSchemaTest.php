<?php

declare(strict_types=1);

namespace Http\GraphQL\Models\RelationSchema\Mutations;

use App\Enums\MatterRelationEnum;
use App\Models\Annotation;
use App\Models\Matter;
use App\Models\MatterRelation;
use App\Models\MatterRelationSchema;
use App\Models\RelationSchema;
use Carbon\Carbon;
use Tests\Http\GraphQL\AbstractHttpGraphQLTestCase;

class PublishRelationSchemaTest extends AbstractHttpGraphQLTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Carbon::setTestNow('2023-01-01 00:00:00');

        RelationSchema::factory()->create([
            'id'           => $this->createUUIDFromID(1),
            'is_published' => true,
            'expired_at'   => null,
        ]);

        RelationSchema::factory()->create([
            'id'           => $this->createUUIDFromID(2),
            'is_published' => false,
            'expired_at'   => null,
        ]);
    }

    /**
     * @test
     */
    public function it_publishes_a_schema_and_expires_the_existing_ones(): void
    {
        $this->graphQL(/** @lang GraphQL */ '
            mutation ($id: UUID!) {
                publishRelationSchema(id: $id) {
                    id
                    isPublished
                    expiredAt
                }
            }
        ', [
            'id' => $this->createUUIDFromID(2),
        ])->assertJson([
            'data' => [
                'publishRelationSchema' => [
                    'id'         => $this->createUUIDFromID(2),
                    'isPublished' => true,
                    'expiredAt'   => null,
                ],
            ],
        ]);

        $this->assertDatabaseHas('relation_schemas', [
            'id'           => $this->createUUIDFromID(1),
            'is_published' => true,
            'expired_at'   => Carbon::now(),
        ]);
    }

    /**
     * @test
     */
    public function it_throws_an_exception_when_schema_is_already_published(): void
    {
        $this->graphQL(/** @lang GraphQL */ '
            mutation ($id: UUID!) {
                publishRelationSchema(id: $id) {
                    id
                    isPublished
                    expiredAt
                }
            }
        ', [
            'id' => $this->createUUIDFromID(1),
        ])->assertGraphQLErrorMessage('The schema is already published.');
    }
}
