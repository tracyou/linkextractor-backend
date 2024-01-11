<?php

declare(strict_types=1);

namespace Http\GraphQL\Models\RelationSchema\Queries;

use App\Models\Law;
use App\Models\Article;
use App\Models\Annotation;
use App\Models\MatterRelationSchema;
use App\Models\RelationSchema;
use Tests\Http\GraphQL\AbstractHttpGraphQLTestCase;

class RelationSchemasTest extends AbstractHttpGraphQLTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        RelationSchema::factory()->create([
            'id'         => $this->createUUIDFromID(1),
            'expired_at' => null,
        ]);

        MatterRelationSchema::factory()->create([
            'id'                 => $this->createUUIDFromID(1),
            'relation_schema_id' => $this->createUUIDFromID(1),
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
                relationSchemas {
                    id
                    isPublished
                    expiredAt
                    annotations {
                        id
                    }
                    matterRelationSchemas {
                        id
                    }
                }
            }
        ')->assertJson([
            'data' => [
                'relationSchemas' => [
                    [
                        'id'          => $this->createUUIDFromID(1),
                        'isPublished' => true,
                        'expiredAt'   => null,
                        'annotations' => [
                            [
                                'id' => $this->createUUIDFromID(1),
                            ],
                            [
                                'id' => $this->createUUIDFromID(2),
                            ],
                        ],
                        'matterRelationSchemas' => [
                            [
                                'id' => $this->createUUIDFromID(1),
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }
}
