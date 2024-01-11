<?php

declare(strict_types=1);

namespace Http\GraphQL\Models\MatterRelationSchema\Queries;

use App\Models\Law;
use App\Models\Article;
use App\Enums\MatterRelationEnum;
use App\Models\Annotation;
use App\Models\Matter;
use App\Models\MatterRelation;
use App\Models\MatterRelationSchema;
use App\Models\RelationSchema;
use Tests\Http\GraphQL\AbstractHttpGraphQLTestCase;

class MatterRelationSchemasTest extends AbstractHttpGraphQLTestCase
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

        $article = Article::factory()->create([
            'law_id' => Law::factory()->create(),
        ]);

        Annotation::factory()->createMany([
            [
                'id'                 => $this->createUUIDFromID(1),
                'relation_schema_id' => $this->createUUIDFromID(1),
                'article_id'         => $article->id,
            ],
            [
                'id'                 => $this->createUUIDFromID(2),
                'relation_schema_id' => $this->createUUIDFromID(1),
                'article_id'         => $article->id,
            ],
        ]);
    }

    /** @test */
    public function it_returns_all_matter_relation_schemas(): void
    {
        $this->graphQL(/** @lang GraphQL */ '
            query {
                matterRelationSchemas {
                    id
                    relations {
                        id
                        relatedMatter {
                            id
                        }
                        description
                        relation
                    }
                }
            }
        ')->assertJson([
            'data' => [
                'matterRelationSchemas' => [
                    [
                        'id'        => $this->createUUIDFromID(1),
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
                    ],
                ],
            ],
        ]);
    }
}
