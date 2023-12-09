<?php

namespace Tests\Http\GraphQL\Models\Pancake\Queries;

use App\Models\Pancake;
use Tests\Http\GraphQL\AbstractHttpGraphQLTestCase;

class PancakesTest extends AbstractHttpGraphQLTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Pancake::factory()->createMany([
            [
                'id' => 111,
            ],
            [
                'id' => 222,
            ],
            [
                'id' => 333,
            ],
        ]);
    }

    /** @test */
    public function it_returns_all_pancakes(): void
    {
        $this->graphQL(/** @lang GraphQL */ '
            query {
                pancakes {
                    id
                }
            }
        ')->assertJson([
            'data' => [
                'pancakes' => [
                    ['id' => 111],
                    ['id' => 222],
                    ['id' => 333],
                ],
            ],
        ]);
    }
}
