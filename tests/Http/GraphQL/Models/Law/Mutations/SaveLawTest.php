<?php

declare(strict_types=1);

namespace Tests\Http\GraphQL\Models\Law\Mutations;

use App\Contracts\Factories\AnnotationFactoryInterface;
use App\Contracts\Factories\ArticleFactoryInterface;
use App\Contracts\Factories\LawFactoryInterface;
use App\Contracts\Factories\MatterFactoryInterface;
use App\Contracts\Factories\MatterRelationSchemaFactoryInterface;

use App\Models\Annotation;
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
        $article = $articleFactory->create($law, 'title of the article', 'this is the text of the article');
        $matterRelationSchema = $matterRelationSchemaFactory->create();

//        $annotation = $annotationFactory->create(
//            $matter,
//            'this is an annotation',
//            10,
//            'this is a comment',
//            $article,
//            $matterRelationSchema
//        );

//        $annotation = Annotation::factory()->create([
//            'id' => $this->createUUIDFromID(1),
//            'text' => 'this is the annotation text',
//            'cursor_index' => 200,
//            'comment' => 'this is the annotation comment',
//            'matter_id' => $matter->id,
//            'matter_relation_schema_id' => $matterRelationSchema->id,
//            'article_id' => $article->id,]);
//        dd($annotation->id);
        $annotationId = $this->createUUIDFromID(1);

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
                         text
                         cursorIndex
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
                        'annotations' => [
                            [
                                'id' => '9b00e35e-bae3-4956-1235-efb3a1e1ddf6',
                                'text' => 'this is the annotation text',
                                'cursorIndex' => 200,
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

//        dd($article);
        dd($response->json());
    }
}
