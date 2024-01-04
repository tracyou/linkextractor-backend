<?php

namespace Tests\Feature;

use App\Contracts\Factories\AnnotationFactoryInterface;
use App\Contracts\Factories\ArticleFactoryInterface;
use App\Contracts\Factories\LawFactoryInterface;
use App\Contracts\Factories\MatterFactoryInterface;
use App\Contracts\Factories\MatterRelationFactoryInterface;
use App\Contracts\Factories\MatterRelationSchemaFactoryInterface;
use App\Contracts\Factories\RelationSchemaFactoryInterface;
use App\Enums\MatterRelationEnum;
use App\Factories\MatterRelationFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MatterFactoryTest extends TestCase
{
    use RefreshDatabase;

    protected AnnotationFactoryInterface $annotationFactory;
    protected MatterFactoryInterface $matterFactory;
    protected LawFactoryInterface $lawFactory;
    protected RelationSchemaFactoryInterface $relationSchemaFactory;
    protected MatterRelationSchemaFactoryInterface $matterRelationSchemaFactory;
    protected ArticleFactoryInterface $articleFactory;
    protected MatterRelationFactoryInterface $matterRelationFactory;

    public function setUp(): void
    {
        parent::setUp();

        $this->annotationFactory = $this->app->make(AnnotationFactoryInterface::class);
        $this->matterFactory = $this->app->make(MatterFactoryInterface::class);
        $this->lawFactory = $this->app->make(LawFactoryInterface::class);
        $this->relationSchemaFactory = $this->app->make(RelationSchemaFactoryInterface::class);
        $this->matterRelationSchemaFactory = $this->app->make(MatterRelationSchemaFactoryInterface::class);
        $this->articleFactory = $this->app->make(ArticleFactoryInterface::class);
        $this->matterRelationFactory = $this->app->make(MatterRelationFactoryInterface::class);
    }

    public function test_matter_has_many_annotations(): void
    {
        // Arrange
        $matter = $this->matterFactory->create('matter', '#001000');
        $law = $this->lawFactory->create('title', false);
        $jsonData = [
            'article 1' => 'oh my god',
            'content' => 'i am so sleepy',
        ];
        $article = $this->articleFactory->create($law, 'title of the article', 'this is the text of the article',$jsonData);
        $relationSchema = $this->relationSchemaFactory->create(false);

        // Act
        $annotation1 = $this->annotationFactory->create(
            $matter,
            'this is an annotation',
            200,
            'this is a comment',
            $article,
            $relationSchema
        );
        $annotation2 = $this->annotationFactory->create(
            $matter,
            'this is an annotation',
            200,
            'this is a comment',
            $article,
            $relationSchema
        );

        // Assert
        $this->assertEquals(2, $matter->annotations->count());
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $matter->annotations);

    }

    public function test_matter_has_many_relations(): void
    {
        // Arrange
        $matterParent = $this->matterFactory->create("matter1", "#000000");
        $matterChild = $this->matterFactory->create("matter2", "#000000");
        $relationSchema = $this->relationSchemaFactory->create(false);
        $matterRelationSchema = $this->matterRelationSchemaFactory->create($matterParent, $relationSchema, '{}');
        $relationSchema = $this->relationSchemaFactory->create(false);

        // Act
        $matterRelation = $this->matterRelationFactory->create($matterChild, $matterRelationSchema, MatterRelationEnum::REQUIRES_ONE(), 'this is a description');

        $matterParent->refresh();
        $matterChild->refresh();


        // Assert
        $this->assertTrue($matterRelation->matterRelationSchema->matter->id === $matterParent->id);
        $this->assertTrue($matterRelation->relatedMatter->id === $matterChild->id);
        $this->assertTrue($matterRelation->matterRelationSchema->id === $matterRelationSchema->id);
        $this->assertTrue($matterParent->matterRelations->isNotEmpty());

    }
}
