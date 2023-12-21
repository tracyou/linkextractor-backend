<?php

namespace Tests\Feature;

use App\Contracts\Factories\AnnotationFactoryInterface;
use App\Contracts\Factories\ArticleFactoryInterface;
use App\Contracts\Factories\LawFactoryInterface;
use App\Contracts\Factories\MatterFactoryInterface;
use App\Contracts\Factories\MatterRelationSchemaFactoryInterface;
use App\Factories\AnnotationFactory;
use App\Factories\MatterFactory;
use App\Factories\MatterRelationFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MatterFactoryTest extends TestCase
{
    use RefreshDatabase;

    protected $annotationFactory;
    protected $matterFactory;
    protected $lawFactory;
    protected $matterRelationSchemaFactory;
    protected $articleFactory;
    protected $matterRelationFactory;
//    protected $matterA;
//    protected $matterB;

    public function setUp(): void
    {
        parent::setUp();

        $this->annotationFactory = $this->app->make(AnnotationFactoryInterface::class);
        $this->matterFactory = $this->app->make(MatterFactoryInterface::class);
        $this->lawFactory = $this->app->make(LawFactoryInterface::class);
        $this->matterRelationSchemaFactory = $this->app->make(MatterRelationSchemaFactoryInterface::class);
        $this->articleFactory = $this->app->make(ArticleFactoryInterface::class);
        $this->matterRelationFactory = $this->app->make(MatterRelationFactory::class);
    }

    public function testMatterHasManyAnnotations(): void
    {
        // Arrange
        $matter = $this->matterFactory->create('matter', '#001000');
        $law = $this->lawFactory->create('title', false);
        $article = $this->articleFactory->create($law, 'title of the article', 'this is the text of the article');
        $matterRelationSchema = $this->matterRelationSchemaFactory->create();

        // Act
        $annotation1 = $this->annotationFactory->create(
            $matter,
            'this is an annotation',
            200,
            'this is a comment',
            $article,
            $matterRelationSchema
        );
        $annotation2 = $this->annotationFactory->create(
            $matter,
            'this is an annotation',
            200,
            'this is a comment',
            $article,
            $matterRelationSchema
        );

        // Assert
        $this->assertEquals(2, $matter->annotations->count());
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $matter->annotations);

    }

    public function testMatterHasManyRelations(): void
    {
        // Arrange
        $matterA = $this->matterFactory->create("matter1", "#000000");
        $matterB = $this->matterFactory->create("matter2", "#000000");
        $matterRelationSchema = $this->matterRelationSchemaFactory->create();

        // Act
        $matterRelation = $this->matterRelationFactory->create($matterA, $matterB, "requires_one", "description", $matterRelationSchema);

        // Assert
        $this->assertTrue($matterRelation->matter_parent_id === $matterA->id);
        $this->assertTrue($matterRelation->matter_child_id === $matterB->id);
        $this->assertTrue($matterRelation->matter_relation_schema_id === $matterRelationSchema->id);

    }
}
