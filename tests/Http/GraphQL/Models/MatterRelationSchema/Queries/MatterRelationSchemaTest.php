<?php

declare(strict_types=1);

namespace Http\GraphQL\Models\MatterRelationSchema\Queries;

use App\Enums\MatterRelationEnum;
use App\Models\Annotation;
use App\Models\Article;
use App\Models\Law;
use App\Models\Matter;
use App\Models\MatterRelation;
use App\Models\MatterRelationSchema;
use App\Models\RelationSchema;
use Tests\Http\GraphQL\AbstractHttpGraphQLTestCase;

class MatterRelationSchemaTest extends AbstractHttpGraphQLTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Matter::factory()->createMany([
            [
                'id' => $this->createUUIDFromID(1),
            ],
            [
                'id' => $this->createUUIDFromID(2),
            ],
            [
                'id' => $this->createUUIDFromID(3),
            ],
        ]);

        RelationSchema::factory()->create([
            'id' => $this->createUUIDFromID(1),
        ]);

        MatterRelationSchema::factory()->create([
            'id'                 => $this->createUUIDFromID(1),
            'matter_id'          => $this->createUUIDFromID(1),
            'relation_schema_id' => $this->createUUIDFromID(1),
        ]);

        MatterRelation::factory()->createMany([
            [
                'id'                        => $this->createUUIDFromID(1),
                'related_matter_id'         => $this->createUUIDFromID(2),
                'matter_relation_schema_id' => $this->createUUIDFromID(1),
                'relation'                  => MatterRelationEnum::REQUIRES_ONE_OR_MORE(),
                'description'               => 'first test description',
            ],
            [
                'id'                        => $this->createUUIDFromID(2),
                'related_matter_id'         => $this->createUUIDFromID(3),
                'matter_relation_schema_id' => $this->createUUIDFromID(1),
                'relation'                  => MatterRelationEnum::REQUIRES_ZERO_OR_MORE(),
                'description'               => 'second test description',
            ],
        ]);
    }

    /** @test */
    public function it_returns_a_matter_relation_schema_by_id(): void
    {
        $this->graphQL(/** @lang GraphQL */ '
            query($relationSchemaId: UUID!, $matterId: UUID!) {
                matterRelationSchema(input: {
                    relationSchemaId: $relationSchemaId,
                    matterId: $matterId,
                }) {
                    id
                    matter {
                        id
                    }
                    relations {
                        id
                        relatedMatter {
                            id
                        }
                        relation
                        description
                    }
                    relationSchema {
                        id
                    }
                }
            }
        ', [
            'relationSchemaId' => $this->createUUIDFromID(1),
            'matterId'         => $this->createUUIDFromID(1),
        ])->assertJson([
            'data' => [
                'matterRelationSchema' => [
                    'id'     => $this->createUUIDFromID(1),
                    'matter' => [
                        'id' => $this->createUUIDFromID(1),
                    ],
                    'relations' => [
                        [
                            'id'            => $this->createUUIDFromID(1),
                            'relatedMatter' => [
                                'id' => $this->createUUIDFromID(2),
                            ],
                            'relation'    => MatterRelationEnum::REQUIRES_ONE_OR_MORE()->key,
                            'description' => 'first test description',
                        ],
                        [
                            'id'            => $this->createUUIDFromID(2),
                            'relatedMatter' => [
                                'id' => $this->createUUIDFromID(3),
                            ],
                            'relation'    => MatterRelationEnum::REQUIRES_ZERO_OR_MORE()->key,
                            'description' => 'second test description',
                        ],
                    ],
                    'relationSchema' => [
                        'id' => $this->createUUIDFromID(1),
                    ],
                ],
            ],
        ]);
    }

    /** @test */
    public function it_throws_an_exception_for_non_existing_id(): void
    {
        $this->graphQL(/** @lang GraphQL */ '
            query($relationSchemaId: UUID!, $matterId: UUID!) {
                matterRelationSchema(input: {
                    relationSchemaId: $relationSchemaId,
                    matterId: $matterId,
                }) {
                    id
                    matter {
                        id
                    }
                    relations {
                        id
                        relatedMatter {
                            id
                        }
                        relation
                    }
                    relationSchema {
                        id
                    }
                }
            }
        ', [
            'relationSchemaId' => $this->createUUIDFromID(3),
            'matterId'         => $this->createUUIDFromID(3),
        ])->assertGraphQLValidationError('input.relationSchemaId', 'The selected input.relation schema id is invalid.');
    }
}
