<?php

namespace Tests\Feature;

use App\Contracts\Factories\AnnotationFactoryInterface;
use App\Contracts\Factories\ArticleFactoryInterface;
use App\Contracts\Factories\LawFactoryInterface;
use App\Contracts\Factories\MatterFactoryInterface;
use App\Contracts\Factories\MatterRelationSchemaFactoryInterface;
use App\Contracts\Factories\RelationSchemaFactoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnnotationFactoryTest extends TestCase
{
    use RefreshDatabase;


    public function test_annotation_belongs_to_matter(): void
    {

        // Arrange

        // Inject factories
        $annotationFactory = $this->app->make(AnnotationFactoryInterface::class);
        $matterFactory = $this->app->make(MatterFactoryInterface::class);
        $lawFactory = $this->app->make(LawFactoryInterface::class);
        $relationSchemaFactory = $this->app->make(RelationSchemaFactoryInterface::class);
        $articleFactory = $this->app->make(ArticleFactoryInterface::class);

        $matter = $matterFactory->create('matter', '#001000');
        $law = $lawFactory->create('title', false);
        $relationSchema = $relationSchemaFactory->create(false);
        $jsonData = [
            'article 1' => 'oh my god',
            'content' => 'i am so sleepy',
        ];
        $article = $articleFactory->create($law,'title of the article', 'this is the text of the article', $jsonData);

        //Act
        $annotation = $annotationFactory->create(
            $matter,
            'this is an annotation',
            'this is the definition of the annotation',
            'this is a comment',
            $article,
            $relationSchema
        );

        // Assert
        $this->assertDatabaseHas('annotations', [
            'id' => $annotation->id,
            'article_id' => $article->id,
            'matter_id' => $matter->id,
            'text'=>'this is an annotation'
        ]);
        $this->assertEquals($article->id, $annotation->article->id);
        $this->assertEquals($matter->id, $annotation->matter->id);
        $this->assertEquals($annotation->matter, $matter);
        $this->assertEquals($annotation->article, $article);


    }


}
