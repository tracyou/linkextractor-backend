<?php

namespace Tests\Http\GraphQL\Models\PancakeStack\Mutations;

use App\Models\PancakeStack;
use Tests\Http\GraphQL\AbstractHttpGraphQLTestCase;

class DeleteTest extends AbstractHttpGraphQLTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        PancakeStack::factory()->create([
            'id' => 111,
        ]);
    }

    /**
     * @test
     */
    public function it_deletes_a_pancake_stack(): void
    {
        $this->graphQL(/** @lang GraphQL */ '
            mutation {
                deletePancakeStack(id: 111)
            }
        ')->assertJson([
            'data' => [
                'deletePancakeStack' => true,
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
                deletePancakeStack(id: 222)
            }
        ')->assertGraphQLValidationError('id', 'The selected id is invalid.');
    }
}
