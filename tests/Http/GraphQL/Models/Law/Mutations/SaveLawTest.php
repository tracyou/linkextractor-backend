<?php

declare(strict_types=1);

namespace Tests\Http\GraphQL\Models\Law\Mutations;

use App\Contracts\Factories\ArticleFactoryInterface;
use App\Contracts\Factories\LawFactoryInterface;
use App\Contracts\Factories\MatterFactoryInterface;
use App\Contracts\Factories\MatterRelationSchemaFactoryInterface;
use App\Contracts\Factories\RelationSchemaFactoryInterface;
use App\Contracts\Repositories\AnnotationRepositoryInterface;
use App\Contracts\Repositories\LawRepositoryInterface;
use App\Models\Annotation;
use App\Models\Article;
use App\Models\Law;
use PHPUnit\Util\Json;
use Tests\Http\GraphQL\AbstractHttpGraphQLTestCase;

class SaveLawTest extends AbstractHttpGraphQLTestCase
{
    /**
     * @test
     */
    public function test(): void
    {
        $law = Law::factory()->create([
            'id' => $this->createUUIDFromID(1),
        ]);

        Article::factory()->createMany([
            [
                'id' => $this->createUUIDFromID(1),
                'law_id' => $this->createUUIDFromID(1),
            ],
            [
                'id' => $this->createUUIDFromID(2),
                'law_id' => $this->createUUIDFromID(1),
            ],
        ]);

        Annotation::factory()->createMany([
            [
                'id' => $this->createUUIDFromID(1),
                'article_id' => $this->createUUIDFromID(1),
                'revision_number' => 1,
            ],
            [
                'id' => $this->createUUIDFromID(2),
                'article_id' => $this->createUUIDFromID(1),
                'revision_number' => 2,
            ],
            [
                'id' => $this->createUUIDFromID(3),
                'article_id' => $this->createUUIDFromID(2),
                'revision_number' => 3,
            ],
        ]);

        $repository = $this->app->make(AnnotationRepositoryInterface::class);

        $this->assertEquals(4, $repository->getNewRevisionNumber($law));
    }

    /**
     * @test
     */
    public function testSaveAnnotatedLaw()
    {
        // Arrange
        $lawFactory = app(LawFactoryInterface::class);
        $articleFactory = app(ArticleFactoryInterface::class);
        $matterFactory = app(MatterFactoryInterface::class);
        $relationSchemaFactory = app(RelationSchemaFactoryInterface::class);

        $matter = $matterFactory->create('matter', '#001000');
        $law = $lawFactory->create('title of the law', false);
        $jsonData = [
            'article 1' => 'oh my god',
            'content' => 'i am so sleepy',
        ];
        $article = $articleFactory->create($law, 'title of the article', 'this is the text of the article', $jsonData, 1);
        $relationSchema = $relationSchemaFactory->create(false);

        $response = $this->graphQL(/** @lang GraphQL */ '
          mutation saveAnnotatedLaw($input: AnnotatedArticleInput!) {
              saveAnnotatedLaw(input: $input) {
                  id
                  title
                  isPublished
                  articles {
                      id
                      title
                      text
                      jsonText
                      annotations {
                         text
                         definition
                         comment
                         matter {
                             id
                         }
                      }
                  }
              }
          }
        ', [
            'input' => [
                'lawId' => $law->id,
                'title' => $law->title,
                'isPublished' => $law->is_published,
                'articles' => [
                    [
                        'articleId' => $article->id,
                        'title' => $article->title,
                        'text' => $article->text,
                        'jsonText' => $article->json_text,
                        'annotations' => [
                            [
                                'text' => 'this is the annotation text',
                                'definition' => 'this is the definition of the annotation',
                                'comment' => 'this is the annotation comment',
                                'matterId' => $matter->id,
                                'tempId' => $this->createUUIDFromID(1)
                            ],
                        ],
                    ],
                ],
            ],
        ]);

        // Assert
        $response->assertStatus(200);
        $response->assertExactJson([
            'data' => [
                'saveAnnotatedLaw' => [
                    'id' => $law->id,
                    'title' => $law->title,
                    'isPublished' => $law->is_published,
                    'articles' => [
                        [
                            'id' => $article->id,
                            'title' => $article->title,
                            'text' => $article->text,
                            'jsonText' => json_encode($article->json_text),
                            'annotations' => [
                                [
                                    'text' => 'this is the annotation text',
                                    'definition' => 'this is the definition of the annotation',
                                    'comment' => 'this is the annotation comment',
                                    'matter' =>
                                        [
                                            'id' => $matter->id,
                                        ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }
}
