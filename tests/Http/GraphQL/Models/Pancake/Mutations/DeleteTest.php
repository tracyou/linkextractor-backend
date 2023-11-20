<?php

namespace Tests\Http\GraphQL\Models\Pancake\Mutations;

use App\Models\Pancake;
use Tests\Http\GraphQL\AbstractHttpGraphQLTestCase;

class DeleteTest extends AbstractHttpGraphQLTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Pancake::factory()->create([
            'id' => 111,
        ]);
    }

    /**
     * @test
     */
    public function it_deletes_a_pancake(): void
    {
        $this->graphQL(/** @lang GraphQL */ '
            mutation {
                deletePancake(id: 111)
            }
        ')->assertJson([
            'data' => [
                'deletePancake' => true,
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
                deletePancake(id: 222)
            }
        ')->assertGraphQLValidationError('id', 'The selected id is invalid.');
    }
}
