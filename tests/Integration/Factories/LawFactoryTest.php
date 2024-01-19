<?php

declare(strict_types=1);

namespace Integration\Factories;

use App\Contracts\Factories\LawFactoryInterface;
use Tests\Http\GraphQL\AbstractHttpGraphQLTestCase;

class LawFactoryTest extends AbstractHttpGraphQLTestCase
{
    protected LawFactoryInterface $lawFactory;

    public function setUp(): void
    {
        parent::setUp();

        // Arrange (injection)
        $this->lawFactory = $this->app->make(LawFactoryInterface::class);
    }

    public function test_create_law()
    {
        // Act
        $this->lawFactory->create('title', true);

        // Assert
        $this->assertDatabaseHas('laws', [
            'title'        => 'title',
            'is_published' => true,
        ]);
    }
}
