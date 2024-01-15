<?php

declare(strict_types=1);

namespace Integration\Factories;

use App\Contracts\Factories\MatterFactoryInterface;
use Tests\Http\GraphQL\AbstractHttpGraphQLTestCase;

class MatterFactoryTest extends AbstractHttpGraphQLTestCase
{
    protected MatterFactoryInterface $matterFactory;

    public function setUp(): void
    {
        parent::setUp();

        // Arrange (injection)
        $this->matterFactory = $this->app->make(MatterFactoryInterface::class);
    }

    public function test_matter_has_many_annotations(): void
    {
        // Act
        $this->matterFactory->create(
            name : 'matter',
            color: '#001000'
        );

        // Assert
        $this->assertDatabaseHas('matters', [
            'name'  => 'matter',
            'color' => '#001000',
        ]);
    }
}
