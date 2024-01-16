<?php

declare(strict_types=1);

namespace Integration\Factories;

use App\Contracts\Factories\ArticleFactoryInterface;
use App\Models\Law;
use Tests\Http\GraphQL\AbstractHttpGraphQLTestCase;

class ArticleFactoryTest extends AbstractHttpGraphQLTestCase
{
    protected ArticleFactoryInterface $articleFactory;

    public function setUp(): void
    {
        parent::setUp();

        $this->articleFactory = $this->app->make(ArticleFactoryInterface::class);
    }

    public function test_creation_of_article(): void
    {
        // Arrange
        $law = Law::factory()->create([
            'id' => $this->createUUIDFromID(1),
        ]);

        // Act
        $article = $this->articleFactory->create(
            law     : $law,
            title   : 'title of the article',
            text    : 'this is the text of the article',
        );

        // Assert
        $this->assertDatabaseHas('articles', [
            'id'    => $article->id,
            'title' => 'title of the article',
            'text'  => 'this is the text of the article',
        ]);
    }

    public function test_relation_with_law()
    {
        // Arrange
        $law = Law::factory()->create([
            'id' => $this->createUUIDFromID(1),
        ]);

        // Act
        $article = $this->articleFactory->create(
            law     : $law,
            title   : 'title of the article',
            text    : 'this is the text of the article',
        );

        // Assert
        $this->assertDatabaseHas('articles', [
            'id'     => $article->id,
            'law_id' => $law->id,
        ]);
    }
}
