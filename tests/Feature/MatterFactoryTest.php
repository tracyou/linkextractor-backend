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
    protected $matterRelation;

    public function setUp(): void
    {
        parent::setUp();

        $this->annotationFactory = $this->app->make(AnnotationFactoryInterface::class);
        $this->matterFactory = $this->app->make(MatterFactoryInterface::class);
        $this->lawFactory = $this->app->make(LawFactoryInterface::class);
        $this->matterRelationSchemaFactory = $this->app->make(MatterRelationSchemaFactoryInterface::class);
        $this->articleFactory = $this->app->make(ArticleFactoryInterface::class);
        $this->matterRelation = $this->app->make(MatterRelationFactory::class);
    }

    public function testMatterHasManyAnnotations(): void
    {
        //Act
        $matter = $this->matterFactory->create('matter', '#001000');
        $law = $this->lawFactory->create('title', false);
        $article = $this->articleFactory->create($law, 'title of the article', 'this is the text of the article');
        $matterRelationSchema = $this->matterRelationSchemaFactory->create();
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
        $matterA = (new MatterFactory())->create("matter1", "#000000");
        $matterB = (new MatterFactory())->create("matter2", "#000000");
        (new MatterRelationFactory())->create($matterA, $matterB, "requires 1", "description");
        $this->assertEquals(1, $matterA->matterRelationsParents->count());
        $this->assertEquals(1, $matterB->matterRelationsChilds->count());
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $matterA->matterRelationsParents);
    }
}
