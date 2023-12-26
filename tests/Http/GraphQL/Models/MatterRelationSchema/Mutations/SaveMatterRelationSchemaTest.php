<?php

declare(strict_types=1);

namespace Http\GraphQL\Models\MatterRelationSchema\Mutations;

use App\Enums\MatterRelationEnum;
use App\Models\Matter;
use App\Models\MatterRelation;
use App\Models\MatterRelationSchema;
use App\Models\RelationSchema;
use Carbon\Carbon;
use Illuminate\Testing\TestResponse;
use Tests\Http\GraphQL\AbstractHttpGraphQLTestCase;

class SaveMatterRelationSchemaTest extends AbstractHttpGraphQLTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Carbon::setTestNow('2023-12-01 12:00:00');

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

        // ------------------------------
        // Schema 1 (published)
        // ------------------------------

        RelationSchema::factory()->create([
            'id'           => $this->createUUIDFromID(1),
            'is_published' => true,
        ]);

        MatterRelationSchema::factory()->create([
            'id'                 => $this->createUUIDFromID(1),
            'relation_schema_id' => $this->createUUIDFromID(1),
            'matter_id'          => $this->createUUIDFromID(1),
        ]);

        MatterRelation::factory()->create([
            'id'                        => $this->createUUIDFromID(1),
            'matter_relation_schema_id' => $this->createUUIDFromID(1),
            'related_matter_id'         => $this->createUUIDFromID(2),
            'relation'                  => MatterRelationEnum::REQUIRES_ONE_OR_MORE(),
            'description'               => 'First relation of schema 1',
        ]);

        // ------------------------------
        // Schema 2 (unpublished)
        // ------------------------------

        RelationSchema::factory()->create([
            'id'           => $this->createUUIDFromID(2),
            'is_published' => false,
        ]);

        MatterRelationSchema::factory()->create([
            'id'                 => $this->createUUIDFromID(2),
            'relation_schema_id' => $this->createUUIDFromID(2),
            'matter_id'          => $this->createUUIDFromID(2),
        ]);

        MatterRelation::factory()->create([
            'id'                        => $this->createUUIDFromID(2),
            'matter_relation_schema_id' => $this->createUUIDFromID(2),
            'related_matter_id'         => $this->createUUIDFromID(3),
            'relation'                  => MatterRelationEnum::REQUIRES_ONE(),
            'description'               => 'First relation of schema 2',
        ]);
    }

    /**
     * @test
     */
    public function it_saves_a_matter_relation_schema_with_relations_for_an_unpublished_schema(): void
    {
        $this->makeRequest([
            'input' => [
                'matterId'               => $this->createUUIDFromID(2),
                'relationSchemaId'       => $this->createUUIDFromID(2),
                'matterRelationSchemaId' => $this->createUUIDFromID(2),
                'relations'              => [
                    [
                        'relatedMatterId' => $this->createUUIDFromID(1),
                        'relation'        => MatterRelationEnum::REQUIRES_ONE_OR_MORE()->key,
                        'description'     => 'Requires one or more',
                    ],
                    [
                        'relatedMatterId' => $this->createUUIDFromID(3),
                        'relation'        => MatterRelationEnum::REQUIRES_ZERO_OR_MORE()->key,
                        'description'     => 'Requires zero or more',
                    ],
                ],
                'schemaLayout'           => '{"test":"test"}',
            ],
        ])->assertJson([
            'data' => [
                'saveMatterRelationSchema' => [
                    'id'             => $this->createUUIDFromID(2),
                    'schemaLayout'   => '{"test":"test"}',
                    'matter'         => [
                        'id' => $this->createUUIDFromID(2),
                    ],
                    'relations'      => [
                        [
                            'relatedMatter' => [
                                'id' => $this->createUUIDFromID(1),
                            ],
                            'relation'      => MatterRelationEnum::REQUIRES_ONE_OR_MORE()->key,
                            'description'   => 'Requires one or more',
                        ],
                        [
                            'relatedMatter' => [
                                'id' => $this->createUUIDFromID(3),
                            ],
                            'relation'      => MatterRelationEnum::REQUIRES_ZERO_OR_MORE()->key,
                            'description'   => 'Requires zero or more',
                        ],
                    ],
                    'relationSchema' => [
                        'id'          => $this->createUUIDFromID(2),
                        'isPublished' => false,
                    ],
                ],
            ],
        ]);

        $this->assertDatabaseHas('matter_relation_schemas', [
            'id'                 => $this->createUUIDFromID(2),
            'relation_schema_id' => $this->createUUIDFromID(2),
            'matter_id'          => $this->createUUIDFromID(2),
            //'schema_layout'      => $this->castAsJson(['test' => 'test']), // <-- This doesn't seem to work, because the postgres JSON type doesn't support an equal operator
        ]);

        $this->assertDatabaseHas('matter_relations', [
            'matter_relation_schema_id' => $this->createUUIDFromID(2),
            'related_matter_id'         => $this->createUUIDFromID(1),
            'relation'                  => MatterRelationEnum::REQUIRES_ONE_OR_MORE(),
            'description'               => 'Requires one or more',
        ]);

        $this->assertDatabaseHas('matter_relations', [
            'matter_relation_schema_id' => $this->createUUIDFromID(2),
            'related_matter_id'         => $this->createUUIDFromID(3),
            'relation'                  => MatterRelationEnum::REQUIRES_ZERO_OR_MORE(),
            'description'               => 'Requires zero or more',
        ]);

        $this->assertDatabaseMissing('matter_relations', [
            'id'                        => $this->createUUIDFromID(2),
            'matter_relation_schema_id' => $this->createUUIDFromID(2),
            'related_matter_id'         => $this->createUUIDFromID(3),
            'relation'                  => MatterRelationEnum::REQUIRES_ONE(),
            'description'               => 'First relation of schema 2',
        ]);
    }

    /**
     * @test
     */
    public function it_saves_a_matter_relation_schema_with_relations_for_a_published_schema(): void
    {
        $this->makeRequest([
            'input' => [
                'matterId'               => $this->createUUIDFromID(1),
                'relationSchemaId'       => $this->createUUIDFromID(1),
                'matterRelationSchemaId' => $this->createUUIDFromID(1),
                'relations'              => [
                    [
                        'relatedMatterId' => $this->createUUIDFromID(2),
                        'relation'        => MatterRelationEnum::REQUIRES_ONE_OR_MORE()->key,
                        'description'     => 'Requires one or more',
                    ],
                    [
                        'relatedMatterId' => $this->createUUIDFromID(3),
                        'relation'        => MatterRelationEnum::REQUIRES_ZERO_OR_MORE()->key,
                        'description'     => 'Requires zero or more',
                    ],
                ],
                'schemaLayout'           => '{"test":"test"}',
            ],
        ])->assertJson([
            'data' => [
                'saveMatterRelationSchema' => [
                    'schemaLayout'   => json_encode(['test' => 'test']),
                    'matter'         => [
                        'id' => $this->createUUIDFromID(1),
                    ],
                    'relations'      => [
                        [
                            'relatedMatter' => [
                                'id' => $this->createUUIDFromID(2),
                            ],
                            'relation'      => MatterRelationEnum::REQUIRES_ONE_OR_MORE()->key,
                            'description'   => 'Requires one or more',
                        ],
                        [
                            'relatedMatter' => [
                                'id' => $this->createUUIDFromID(3),
                            ],
                            'relation'      => MatterRelationEnum::REQUIRES_ZERO_OR_MORE()->key,
                            'description'   => 'Requires zero or more',
                        ],
                    ],
                    'relationSchema' => [
                        'isPublished' => false,
                    ],
                ],
            ],
        ]);

        $this->assertDatabaseCount('relation_schemas', 3);

        $this->assertDatabaseCount('matter_relation_schemas', 3);

        $this->assertDatabaseHas('matter_relations', [
            'related_matter_id' => $this->createUUIDFromID(2),
            'relation'          => MatterRelationEnum::REQUIRES_ONE_OR_MORE(),
            'description'       => 'Requires one or more',
        ]);

        $this->assertDatabaseHas('matter_relations', [
            'related_matter_id' => $this->createUUIDFromID(3),
            'relation'          => MatterRelationEnum::REQUIRES_ZERO_OR_MORE(),
            'description'       => 'Requires zero or more',
        ]);
    }

    /**
     * @test
     */
    public function it_copies_matter_relation_schemas_to_new_relation_schema_when_published(): void
    {
        $response = $this->makeRequest([
            'input' => [
                'matterId'         => $this->createUUIDFromID(2),
                'relationSchemaId' => $this->createUUIDFromID(1),
                'relations'        => [
                    [
                        'relatedMatterId' => $this->createUUIDFromID(1),
                        'relation'        => MatterRelationEnum::REQUIRES_ONE_OR_MORE()->key,
                        'description'     => 'Requires one or more',
                    ],
                    [
                        'relatedMatterId' => $this->createUUIDFromID(3),
                        'relation'        => MatterRelationEnum::REQUIRES_ZERO_OR_MORE()->key,
                        'description'     => 'Requires zero or more',
                    ],
                ],
                'schemaLayout'     => '{"test":"test"}',
            ],
        ]);

        $response->assertJson([
            'data' => [
                'saveMatterRelationSchema' => [
                    // 'id'             => $this->createUUIDFromID(2), // <-- This is a new id, because the schema is published and a new schema is created
                    'schemaLayout'   => json_encode(['test' => 'test']),
                    'matter'         => [
                        'id' => $this->createUUIDFromID(2),
                    ],
                    'relations'      => [
                        [
                            'relatedMatter' => [
                                'id' => $this->createUUIDFromID(1),
                            ],
                            'relation'      => MatterRelationEnum::REQUIRES_ONE_OR_MORE()->key,
                            'description'   => 'Requires one or more',
                        ],
                        [
                            'relatedMatter' => [
                                'id' => $this->createUUIDFromID(3),
                            ],
                            'relation'      => MatterRelationEnum::REQUIRES_ZERO_OR_MORE()->key,
                            'description'   => 'Requires zero or more',
                        ],
                    ],
                    'relationSchema' => [
                        // 'id'          => $this->createUUIDFromID(2), // <-- This is a new id, because the schema is published and a new schema is created
                        'isPublished' => false,
                    ],
                ],
            ],
        ]);

        $this->assertDatabaseCount('relation_schemas', 3);

        $this->assertDatabaseCount('matter_relation_schemas', 4);

        $this->assertDatabaseHas('matter_relations', [
            'related_matter_id' => $this->createUUIDFromID(1),
            'relation'          => MatterRelationEnum::REQUIRES_ONE_OR_MORE(),
            'description'       => 'Requires one or more',
        ]);

        $this->assertDatabaseHas('matter_relations', [
            'related_matter_id' => $this->createUUIDFromID(3),
            'relation'          => MatterRelationEnum::REQUIRES_ZERO_OR_MORE(),
            'description'       => 'Requires zero or more',
        ]);

        $this->assertDatabaseHas('matter_relation_schemas', [
            'relation_schema_id' => $response->json('data.saveMatterRelationSchema.relationSchema.id'),
            'matter_id'          => $this->createUUIDFromID(1),
        ]);

        $copiedMatterRelationSchema = MatterRelationSchema::where('relation_schema_id', $response->json('data.saveMatterRelationSchema.relationSchema.id'))
            ->where('matter_id', $this->createUUIDFromID(1))
            ->first();

        $this->assertDatabaseHas('matter_relations', [
            'matter_relation_schema_id' => $copiedMatterRelationSchema->getKey(),
            'related_matter_id'         => $this->createUUIDFromID(2),
            'relation'                  => MatterRelationEnum::REQUIRES_ONE_OR_MORE(),
            'description'               => 'First relation of schema 1',
        ]);
    }

    /**
     * @test
     */
    public function it_throws_an_exception_for_non_existing_matter_id(): void
    {
        $this->makeRequest([
            'input' => [
                'matterId'               => $this->createUUIDFromID(1),
                'relationSchemaId'       => $this->createUUIDFromID(1),
                'matterRelationSchemaId' => $this->createUUIDFromID(1),
                'relations'              => [
                    [
                        'relatedMatterId' => $this->createUUIDFromID(4),
                        'relation'        => MatterRelationEnum::REQUIRES_ONE_OR_MORE()->key,
                        'description'     => 'Requires one or more',
                    ],
                ],
                'schemaLayout'           => '{"test":"test"}',
            ],
        ])->assertGraphQLValidationError('input.relations.0.relatedMatterId', 'The selected input.relations.0.relatedMatterId is invalid.');

        $this->makeRequest([
            'input' => [
                'matterId'               => $this->createUUIDFromID(4),
                'relationSchemaId'       => $this->createUUIDFromID(1),
                'matterRelationSchemaId' => $this->createUUIDFromID(1),
                'relations'              => [
                    [
                        'relatedMatterId' => $this->createUUIDFromID(2),
                        'relation'        => MatterRelationEnum::REQUIRES_ONE_OR_MORE()->key,
                        'description'     => 'Requires one or more',
                    ],
                ],
                'schemaLayout'           => '{"test":"test"}',
            ],
        ])->assertGraphQLValidationError('input.matterId', 'The selected input.matter id is invalid.');
    }

    /**
     * @test
     */
    public function it_throws_an_exception_for_equal_matter_ids(): void
    {
        $this->makeRequest([
            'input' => [
                'matterId'               => $this->createUUIDFromID(2),
                'relationSchemaId'       => $this->createUUIDFromID(1),
                'matterRelationSchemaId' => $this->createUUIDFromID(1),
                'relations'              => [
                    [
                        'relatedMatterId' => $this->createUUIDFromID(2),
                        'relation'        => MatterRelationEnum::REQUIRES_ONE_OR_MORE()->key,
                        'description'     => 'Requires one or more',
                    ],
                ],
                'schemaLayout'           => '{"test":"test"}',
            ],
        ])->assertGraphQLValidationError('input.relations.0.relatedMatterId', 'The related matter id cannot be the same as the matter id.');
    }

    /**
     * @param array<string, mixed> $data
     *
     * @return TestResponse
     */
    protected function makeRequest(array $data): TestResponse
    {
        return $this->graphQL(/** @lang GraphQL */ '
            mutation($input: SaveMatterRelationSchemaInput!) {
                saveMatterRelationSchema(input: $input) {
                    id
                    schemaLayout
                    matter {
                        id
                    }
                    relations {
                        relatedMatter {
                            id
                        }
                        relation
                        description
                    }
                    relationSchema {
                        id
                        isPublished
                    }
                }
            }
        ', $data);
    }
}
