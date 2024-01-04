<?php

namespace Tests\Feature;

use App\Contracts\Factories\AnnotationFactoryInterface;
use App\Contracts\Factories\ArticleFactoryInterface;
use App\Contracts\Factories\LawFactoryInterface;
use App\Contracts\Factories\MatterFactoryInterface;
use App\Contracts\Factories\MatterRelationFactoryInterface;
use App\Contracts\Factories\MatterRelationSchemaFactoryInterface;
use App\Factories\MatterRelationFactory;
use App\Models\Annotation;
use App\Models\Article;
use App\Models\Law;
use App\Models\Matter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LawFactoryTest extends TestCase
{
    use RefreshDatabase;

    protected AnnotationFactoryInterface $annotationFactory;
    protected MatterFactoryInterface $matterFactory;
    protected LawFactoryInterface $lawFactory;
    protected MatterRelationSchemaFactoryInterface $matterRelationSchemaFactory;
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
    }

    public function test_create_law()
    {
        // Arrange create law object
        $law = $this->lawFactory->create('title', false);
        $jsonData = [
            'article 1' => 'oh my god',
            'content' => 'i am so sleepy',
        ];

        //Act
        $article = $this->articleFactory->create($law, 'title of the article', 'this is the text of the article',$jsonData);

        // Act
        $title = $law->title;
        $isPublished = $law->is_published;

        // Assert
        $this->assertInstanceOf(Law::class, $law, 'Created object should be an instance of Law');
        $this->assertEquals("title", $title, 'Title should be set correctly');
        $this->assertFalse($isPublished, 'isPublished should be set correctly');
    }


    public function test_relation_with_articles()
    {
        //Arrange
        $law = $this->lawFactory->create('title', false);
        $jsonData = [
            'article 1' => 'oh my god',
            'content' => 'i am so sleepy',
        ];

        //Act
        $article = $this->articleFactory->create($law, 'title of the article', 'this is the text of the article',$jsonData);

        // Assert
        $this->assertEquals(1, $law->articles->count());
        $this->assertEquals($article->law->id,$law->id);


    }
}
