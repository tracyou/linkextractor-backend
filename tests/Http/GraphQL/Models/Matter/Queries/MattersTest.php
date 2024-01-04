<?php

declare(strict_types=1);

namespace Http\GraphQL\Models\Matter\Queries;

use App\Models\Matter;
use Tests\Http\GraphQL\AbstractHttpGraphQLTestCase;

class MattersTest extends AbstractHttpGraphQLTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Matter::factory()->createMany([
            [
                'id' => $this->createUUIDFromID(1),
            ],
            [
                'id' => $this->createUUIDFromID(2),
            ],
            [
                'id' => $this->createUUIDFromID(3),
            ],
        ]);
    }

    /** @test */
    public function it_returns_all_matters(): void
    {
        $this->graphQL(/** @lang GraphQL */ '
            query {
                matters {
                    id
                }
            }
        ')->assertJson([
            'data' => [
                'matters' => [
                    ['id' => $this->createUUIDFromID(1)],
                    ['id' => $this->createUUIDFromID(2)],
                    ['id' => $this->createUUIDFromID(3)],
                ],
            ],
        ]);
    }
}
