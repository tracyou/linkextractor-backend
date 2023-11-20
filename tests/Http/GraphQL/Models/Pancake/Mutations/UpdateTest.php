<?php

namespace Tests\Http\GraphQL\Models\Pancake\Mutations;

use App\Models\Pancake;
use Tests\Http\GraphQL\AbstractHttpGraphQLTestCase;

class UpdateTest extends AbstractHttpGraphQLTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Pancake::factory()->create([
            'id' => 111,
            'diameter' => 20,
        ]);
    }

    /**
     * @test
     */
    public function it_updates_a_pancake(): void
    {
        $this->graphQL(/** @lang GraphQL */ '
            mutation {
                updatePancake(input: {
                    id: 111
                    diameter: 10
                }) {
                    id
                    diameter
                }
            }
        ')->assertJson([
            'data' => [
                'updatePancake' => [
                    'id' => 111,
                    'diameter' => 10,
                ],
            ],
        ]);
    }

    /**
     * @test
     */
    public function it_throws_an_exception_for_non_existing_id(): void
    {
        $this->graphQL(/** @lang GraphQL */ '
            mutation {
                updatePancake(input: {
                    id: 222
                    diameter: 10
                }) {
                    id
                    diameter
                }
            }
        ')->assertGraphQLValidationError('input.id', 'The selected input.id is invalid.');
    }
}
