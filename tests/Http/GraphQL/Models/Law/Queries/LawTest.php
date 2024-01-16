<?php

declare(strict_types=1);

namespace Tests\Http\GraphQL\Models\Law\Queries;

use App\Models\Annotation;
use App\Models\Article;
use App\Models\ArticleRevision;
use App\Models\Law;
use Tests\Http\GraphQL\AbstractHttpGraphQLTestCase;

class LawTest extends AbstractHttpGraphQLTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Law::factory()->create([
            'id' => $this->createUUIDFromID(1),
        ]);

        Article::factory()->create([
            'id'     => $this->createUUIDFromID(1),
            'law_id' => $this->createUUIDFromID(1),
        ]);

        ArticleRevision::factory()->create([
            'id'         => $this->createUUIDFromID(1),
            'article_id' => $this->createUUIDFromID(1),
        ]);

        Annotation::factory()->create([
            'id'                  => $this->createUUIDFromID(1),
            'article_revision_id' => $this->createUUIDFromID(1),
        ]);
    }

    /**
     * @test
     */
    public function it_returns_a_law_by_id(): void
    {
        $this->graphQL(/** @lang GraphQL */ '
            query($id: UUID!) {
                law(id: $id) {
                    id
                    articles {
                        id
                        latestRevision {
                            id
                            annotations {
                                id
                            }
                        }
                    }
                }
            }
        ', [
            'id' => $this->createUUIDFromID(1),
        ])->assertJson([
            'data' => [
                'law' => [
                    'id'       => $this->createUUIDFromID(1),
                    'articles' => [
                        [
                            'id'             => $this->createUUIDFromID(1),
                            'latestRevision' => [
                                'id'          => $this->createUUIDFromID(1),
                                'annotations' => [
                                    [
                                        'id' => $this->createUUIDFromID(1),
                                    ],
                                ],
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
    public function it_throws_a_validation_error_for_unknown_law_id(): void
    {
        $this->graphQL(/** @lang GraphQL */ '
            query($id: UUID!) {
                law(id: $id) {
                    id
                }
            }
        ', [
            'id' => $this->createUUIDFromID(222),
        ])->assertGraphQLValidationError('id', 'The selected id is invalid.');
    }
}
