<?php

declare(strict_types=1);

namespace Tests\Http\GraphQL\Models\Law\Mutations;

use App\Contracts\Factories\AnnotationFactoryInterface;
use App\Contracts\Factories\ArticleFactoryInterface;
use App\Contracts\Factories\LawFactoryInterface;
use App\Contracts\Factories\MatterFactoryInterface;
use App\Contracts\Factories\MatterRelationFactoryInterface;
use App\Contracts\Factories\MatterRelationSchemaFactoryInterface;
use App\Models\Annotation;
use App\Models\Article;
use App\Models\Law;
use App\Models\Matter;
use App\Models\MatterRelationSchema;
use Tests\Http\GraphQL\AbstractHttpGraphQLTestCase;

class SaveLawTest extends AbstractHttpGraphQLTestCase
{
    public function testSaveAnnotatedLaw()
    {
        // Arrange
        $lawFactory = app(LawFactoryInterface::class);
        $articleFactory = app(ArticleFactoryInterface::class);
        $annotationFactory = app(AnnotationFactoryInterface::class);
        $matterFactory = app(MatterFactoryInterface::class);
        $matterRelationSchemaFactory = app(MatterRelationSchemaFactoryInterface::class);

        $matter = $matterFactory->create('matter', '#001000');
        $law = $lawFactory->create('title', false);
        $article = $articleFactory->create($law,'title of the article', 'this is the text of the article');
        $matterRelationSchema = $matterRelationSchemaFactory->create();

        $annotation = $annotationFactory->create(
            $matter,
            'this is an annotation',
            200,
            'this is a comment',
            $article,
            $matterRelationSchema
        );


        // Act
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
                      annotations {
                         id
                         comment
                         cursorIndex
                         matter{
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
                        'annotations' => [
                            [
                                'id' => $annotation->id,
                                'comment' => $annotation->comment,
                                'cursorIndex' => $annotation->cursor_index,
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

        dd($response->json());
//        $response->assertJson([
//            //
//        ]);

    }
}
