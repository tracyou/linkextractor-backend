<?php

namespace Http\GraphQL\Models\Law\Mutations;

use App\Models\Law;
use Tests\Http\GraphQL\AbstractHttpGraphQLTestCase;

class DeleteLawsTest extends AbstractHttpGraphQLTestCase
{
    /** @test */
    public function delete_law(): void
    {
        $law = Law::factory()->create();

        $this->graphQL(/** @lang GraphQL */ '
            mutation($id: UUID!) {
                deleteLaw(input: $id)
            }
        ', [
            'id' => $law->id,
        ])->assertJson([
            'data' => [
                'deleteLaw' => true,
            ],
        ]);

        $this->assertSoftDeleted('laws', ['id' => $law->id]);
    }

    /** @test */
    public function delete_law_with_non_existing_law(): void
    {
        $this->graphQL(/** @lang GraphQL */ '
            mutation($id: UUID!) {
                deleteLaw(input: $id)
            }
        ', [
            'id' => $this->createUUIDFromID(1),
        ])->assertGraphQLErrorMessage('This id is incorrect');
    }
}
