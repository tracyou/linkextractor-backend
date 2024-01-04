<?php

namespace Tests\Feature;

use App\Contracts\Factories\AnnotationFactoryInterface;
use App\Contracts\Factories\ArticleFactoryInterface;
use App\Contracts\Factories\LawFactoryInterface;
use App\Contracts\Factories\MatterFactoryInterface;
use App\Contracts\Factories\MatterRelationFactoryInterface;
use App\Contracts\Factories\MatterRelationSchemaFactoryInterface;
use App\Contracts\Factories\RelationSchemaFactoryInterface;
use App\Factories\MatterRelationFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MatterRelationSchemaFactoryTest extends TestCase
{

    use RefreshDatabase;

    protected AnnotationFactoryInterface $annotationFactory;
    protected MatterFactoryInterface $matterFactory;
    protected LawFactoryInterface $lawFactory;
    protected RelationSchemaFactoryInterface $relationSchemaFactory;
    protected ArticleFactoryInterface $articleFactory;
    protected MatterRelationFactoryInterface $matterRelationFactory;

    public function setUp(): void
    {
        parent::setUp();

        $this->annotationFactory = $this->app->make(AnnotationFactoryInterface::class);
        $this->matterFactory = $this->app->make(MatterFactoryInterface::class);
        $this->lawFactory = $this->app->make(LawFactoryInterface::class);
        $this->matterRelationSchemaFactory = $this->app->make(MatterRelationSchemaFactoryInterface::class);
        $this->articleFactory = $this->app->make(ArticleFactoryInterface::class);
        $this->matterRelationFactory = $this->app->make(MatterRelationFactory::class);

        $this->matterFactory = $this->app->make(MatterFactoryInterface::class);
        $this->matterRelationSchemaFactory = $this->app->make(MatterRelationSchemaFactoryInterface::class);
        $this->matterRelationFactory = $this->app->make(MatterRelationFactory::class);
    }

    public function test_creation_of_matter_relation_schema()
    {

        // Arrange


        $matter = $this->matterFactory->create('matter', '#001000');
        $law = $this->lawFactory->create('title', false);
        $jsonData = [
            'article 1' => 'oh my god',
            'content' => 'i am so sleepy',
        ];
        $article = $this->articleFactory->create($law, 'title of the article', 'this is the text of the article', $jsonData);
        $relationSchema = $this->relationSchemaFactory->create(false);

        //Act
        $annotation = $this->annotationFactory->create(
            $matter,
            'this is an annotation',
            200,
            'this is a comment',
            $article,
            $relationSchema
        );
        $annotation1 = $this->annotationFactory->create(
            $matter,
            'this is another annotation',
            'this the difinition',
            'this is a comment',
            $article,
            $relationSchema
        );

        // Assert
        $this->assertDatabaseHas('matter_relations', [
            'id' => $relationSchema->id,
        ]);

    }

    public function test_relation_with_annotation()
    {
        // Arrange


        $matter = $this->matterFactory->create('matter', '#001000');
        $law = $this->lawFactory->create('title', false);
        $jsonData = [
            'article 1' => 'oh my god',
            'content' => 'i am so sleepy',
        ];
        $article = $this->articleFactory->create($law, 'title of the article', 'this is the text of the article', $jsonData);
        $relationSchema = $this->relationSchemaFactory->create(false);

        //Act
        $annotation = $this->annotationFactory->create(
            $matter,
            'this is an annotation',
            200,
            'this is a comment',
            $article,
            $relationSchema
        );
        $annotation1 = $this->annotationFactory->create(
            $matter,
            'this is another annotation',
            200,
            'this is a comment',
            $article,
            $relationSchema
        );

        // Assert
        $annotation1->refresh();
        $relationSchema->refresh();
        $this->assertEquals(2, $relationSchema->annotations->count());
    }

    public function test_the_relation_matter_relation()
    {
        // Arrange
        $matterParent = $this->matterFactory->create("matter1", "#000000");
        $matterChild = $this->matterFactory->create("matter2", "#000000");
        $matterChild1 = $this->matterFactory->create("matterChild2", "#000000");
        $relationSchema = $this->relationSchemaFactory->create(false);


        // Act
        $matterRelation = $this->matterRelationFactory->create($matterParent, $matterChild, "requires_one", "description", $relationSchema);
        $matterRelation1 = $this->matterRelationFactory->create($matterParent, $matterChild1, "requires_one", "description of another matter relation", $relationSchema);

        // Assert
        $this->assertEquals(2, $relationSchema->matterRelations->count());

    }

}
