<?php

declare(strict_types=1);

namespace Http\GraphQL\Models\RelationSchema\Queries;

use App\Enums\MatterRelationEnum;
use App\Models\Annotation;
use App\Models\Matter;
use App\Models\MatterRelation;
use App\Models\MatterRelationSchema;
use App\Models\RelationSchema;
use Tests\Http\GraphQL\AbstractHttpGraphQLTestCase;

class RelationSchemaTest extends AbstractHttpGraphQLTestCase
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
            'id'         => $this->createUUIDFromID(1),
            'expired_at' => null,
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

        Annotation::factory()->createMany([
            [
                'id'                 => $this->createUUIDFromID(1),
                'relation_schema_id' => $this->createUUIDFromID(1),
            ],
            [
                'id'                 => $this->createUUIDFromID(2),
                'relation_schema_id' => $this->createUUIDFromID(1),
            ],
        ]);
    }

    /**
     * @test
     */
    public function it_returns_a_matter_relation_schema_by_id(): void
    {
        $this->graphQL(/** @lang GraphQL */ '
            query($id: UUID!) {
                relationSchema(id: $id) {
                    id
                    expiredAt
                    matterRelationSchemas {
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
            }
        ', [
            'id' => $this->createUUIDFromID(1),
        ])->assertJson([
            'data' => [
                'relationSchema' => [
                    'id'                    => $this->createUUIDFromID(1),
                    'expiredAt'             => null,
                    'matterRelationSchemas' => [
                        [
                            'id'             => $this->createUUIDFromID(1),
                            'matter'         => [
                                'id' => $this->createUUIDFromID(1),
                            ],
                            'relations'      => [
                                [
                                    'id'            => $this->createUUIDFromID(1),
                                    'relatedMatter' => [
                                        'id' => $this->createUUIDFromID(2),
                                    ],
                                    'relation'      => MatterRelationEnum::REQUIRES_ONE_OR_MORE()->key,
                                    'description'   => 'first test description',
                                ],
                                [
                                    'id'            => $this->createUUIDFromID(2),
                                    'relatedMatter' => [
                                        'id' => $this->createUUIDFromID(3),
                                    ],
                                    'relation'      => MatterRelationEnum::REQUIRES_ZERO_OR_MORE()->key,
                                    'description'   => 'second test description',
                                ],
                            ],
                            'relationSchema' => [
                                'id' => $this->createUUIDFromID(1),
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }

    /**
     * @test
     */
    public function it_throws_an_exception_for_non_existing_id(): void
    {
        $this->graphQL(/** @lang GraphQL */ '
            query($id: UUID!) {
                relationSchema(id: $id) {
                    id
                    expiredAt
                    matterRelationSchemas {
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
            }
        ', [
            'id' => $this->createUUIDFromID(2),
        ])->assertGraphQLValidationError('id', 'The selected id is invalid.');
    }
}
