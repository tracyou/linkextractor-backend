<?php

namespace Tests\Http\GraphQL\Models\Pancake\Queries;

use App\Models\Pancake;
use Tests\Http\GraphQL\AbstractHttpGraphQLTestCase;

class PancakeByIdTest extends AbstractHttpGraphQLTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Pancake::factory()->createMany([
            [
                'id'   => 111,
            ],
            [
                'id'   => 222,
            ],
            [
                'id'   => 333,
            ],
        ]);
    }

    /**
     * @test
     */
    public function it_returns_a_pancake_by_id(): void
    {
        $this->graphQL(/** @lang GraphQL */ '
            query {
                pancakeById(id: 111) {
                    id
                }
            }
        ')->assertJson([
            'data' => [
                'pancakeById' => [
                    'id' => 111,
                ],
            ],
        ]);
    }

    /**
     * @test
     */
    public function it_throws_an_exception_when_the_pancake_does_not_exist(): void
    {
        $this->graphQL(/** @lang GraphQL */ '
            query {
                pancakeById(id: 999) {
                    id
                }
            }
        ')->assertGraphQLValidationError('id', 'The selected id is invalid.');
    }
}
