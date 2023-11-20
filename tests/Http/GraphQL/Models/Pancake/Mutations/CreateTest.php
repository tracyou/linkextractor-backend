<?php

namespace Tests\Http\GraphQL\Models\Pancake\Mutations;

use Tests\Http\GraphQL\AbstractHttpGraphQLTestCase;

class CreateTest extends AbstractHttpGraphQLTestCase
{
    /**
     * @test
     */
    public function it_creates_a_pancake(): void
    {
        $this->graphQL(/** @lang GraphQL */ '
            mutation {
                createPancake(input: {
                    diameter: 32,
                }) {
                    diameter
                }
            }
        ')->assertJson([
            'data' => [
                'createPancake' => [
                    'diameter' => 32,
                ],
            ],
        ]);
    }
}
