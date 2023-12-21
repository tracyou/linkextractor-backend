<?php

namespace Tests\Feature;

use App\Contracts\Factories\AnnotationFactoryInterface;
use App\Contracts\Factories\ArticleFactoryInterface;
use App\Contracts\Factories\LawFactoryInterface;
use App\Contracts\Factories\MatterFactoryInterface;
use App\Contracts\Factories\MatterRelationFactoryInterface;
use App\Contracts\Factories\MatterRelationSchemaFactoryInterface;
use App\Factories\MatterRelationFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleFactoryTest extends TestCase
{
    use RefreshDatabase;

    protected LawFactoryInterface $lawFactory;
    protected ArticleFactoryInterface $articleFactory;

    public function setUp(): void
    {
        parent::setUp();

        $this->lawFactory = $this->app->make(LawFactoryInterface::class);
        $this->articleFactory = $this->app->make(ArticleFactoryInterface::class);
    }

    public function test_creation_of_article(): void
    {
        // Arrange
        $law = $this->lawFactory->create('title', false);

        // Act
        $article = $this->articleFactory->create($law, 'title of the article', 'this is the text of the article');

        // Assert
        $this->assertDatabaseHas('articles', [
            'id' => $article->id,
        ]);

    }

    public function test_relation_with_law()
    {
        // Arrange
        $law = $this->lawFactory->create('title', false);

        // Act
        $article = $this->articleFactory->create($law, 'title of the article', 'this is the text of the article');

        // Assert
        $this->assertDatabaseHas('articles', [
            'law_id' => $law->id,
        ]);
        $this->assertEquals($article->law->id, $law->id);


    }

}
