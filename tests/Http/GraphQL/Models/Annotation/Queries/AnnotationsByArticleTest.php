<?php

declare(strict_types=1);

namespace Http\GraphQL\Models\Annotation\Queries;

use App\Models\Law;
use App\Models\Matter;
use App\Models\Article;
use App\Models\Annotation;
use Tests\Http\GraphQL\AbstractHttpGraphQLTestCase;

class AnnotationsByArticleTest extends AbstractHttpGraphQLTestCase
{
    /** @test */
    public function it_returns_all_annotations_for_given_law(): void
    {
        $this->graphQL(/** @lang GraphQL */ '
            query($id: UUID!) {
                annotationsByArticle(articleId: $id) {
                    id
                    matter {
                        id
                    }
                }
            }
        ',
            [
                'id' => $this->createUUIDFromID(3),
            ],
        )->assertJson([
            'data' => [
                'annotationsByArticle' => [
                    [
                        'id' => $this->createUUIDFromID(5),
                        'matter' => [
                            'id' => $this->createUUIDFromID(2)
                        ]
                    ],
                ],
            ],
        ]);
    }

    /** @test */
    public function it_throws_a_validation_error_for_non_existing_law_id(): void
    {
        $this->graphQL(/** @lang GraphQL */ '
            query($id: UUID!) {
                annotationsByArticle(articleId: $id) {
                    id,
                    matter {
                        id
                    }
                }
            }
        ',
            [
                'id' => $this->createUUIDFromID(12),
            ],
        )->assertGraphQLValidationError('articleId', 'The selected article id is invalid.');
    }

    protected function setUp(): void
    {
        parent::setUp();

        $law = Law::factory()->create([
            'id' => $this->createUUIDFromID(1),
        ]);

        $matter1 = Matter::factory()->create([
            'id' => $this->createUUIDFromID(2),
        ]);

        $article = Article::factory()->create([
            'id'     => $this->createUUIDFromID(3),
            'law_id' => $law->id,
        ]);

        $article2 = Article::factory()->create([
            'id'     => $this->createUUIDFromID(4),
            'law_id' => $law->id,
        ]);

        $annotation1 = Annotation::factory()->create([
            'id'         => $this->createUUIDFromID(5),
            'article_id' => $article->id,
            'matter_id'  => $matter1->getKey(),
        ]);

        $matter2 = Matter::factory()->create([
            'id' => $this->createUUIDFromID(6),
        ]);

        $annotation2 = Annotation::factory()->create([
            'id'         => $this->createUUIDFromID(7),
            'article_id' => $article2->id,
            'matter_id'  => $matter2->getKey(),
        ]);


    }
}
