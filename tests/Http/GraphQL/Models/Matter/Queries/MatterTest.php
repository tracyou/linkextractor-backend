<?php

declare(strict_types=1);

namespace Http\GraphQL\Models\Matter\Queries;

use App\Models\Matter;
use Tests\Http\GraphQL\AbstractHttpGraphQLTestCase;

class MatterTest extends AbstractHttpGraphQLTestCase
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

    /**
     * @test
     */
    public function it_returns_a_matter_by_id(): void
    {
        $this->graphQL(/** @lang GraphQL */ '
            query($id: UUID!) {
                matter(id: $id) {
                    id
                }
            }
        ',
            [
                'id' => $this->createUUIDFromID(2),
            ]
        )->assertJson([
            'data' => [
                'matter' => [
                    'id' => $this->createUUIDFromID(2),
                ],
            ],
        ]);
    }

    /**
     * @test
     */
    public function it_throws_a_validation_error_for_non_existing_id(): void
    {
        $this->graphQL(/** @lang GraphQL */ '
            query($id: UUID!) {
                matter(id: $id) {
                    id
                }
            }
        ',
            [
                'id' => $this->createUUIDFromID(4),
            ]
        )->assertGraphQLValidationError('id', 'The selected id is invalid.');
    }
}
