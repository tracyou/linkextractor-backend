<?php

declare(strict_types=1);

namespace Tests\Http\GraphQL\Models\Law\Mutations;

use App\Contracts\Factories\ArticleFactoryInterface;
use App\Contracts\Factories\LawFactoryInterface;
use App\Contracts\Factories\MatterFactoryInterface;
use App\Contracts\Factories\MatterRelationSchemaFactoryInterface;
use PHPUnit\Util\Json;
use Tests\Http\GraphQL\AbstractHttpGraphQLTestCase;

class SaveLawTest extends AbstractHttpGraphQLTestCase
{
    public function testSaveAnnotatedLaw()
    {
        // Arrange
        $lawFactory = app(LawFactoryInterface::class);
        $articleFactory = app(ArticleFactoryInterface::class);
        $matterFactory = app(MatterFactoryInterface::class);
        $matterRelationSchemaFactory = app(MatterRelationSchemaFactoryInterface::class);

        $matter = $matterFactory->create('matter', '#001000');
        $law = $lawFactory->create('title of the law', false);
        $jsonData = [
            'article 1' => 'oh my god',
            'content' => 'i am so sleepy',
        ];
        $jsonText = new Json(json_encode($jsonData));
        $article = $articleFactory->create($law, 'title of the article', 'this is the text of the article', $jsonData);
        $matterRelationSchema = $matterRelationSchemaFactory->create();


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
                      textJson
                      annotations {
                         text
                         definition
                         comment
                         matter {
                             id
                         }
                         matterRelationSchema {
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
                        'textJson' => $article->json_text,
                        'annotations' => [
                            [
                                'text' => 'this is the annotation text',
                                'definition' => 'this is the definition of the annotation',
                                'comment' => 'this is the annotation comment',
                                'matterId' => $matter->id,
                                'matterRelationSchemaId' => $matterRelationSchema->id,
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
                            'textJson' => json_encode($article->json_text),
                            'annotations' => [
                                [
                                    'text' => 'this is the annotation text',
                                    'definition' => 'this is the definition of the annotation',
                                    'comment' => 'this is the annotation comment',
                                    'matter' => [
                                        'id' => $matter->id,
                                    ],
                                    'matterRelationSchema' => [
                                        'id' => $matterRelationSchema->id,
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
