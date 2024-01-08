<?php

declare(strict_types=1);

namespace Http\GraphQL\Models\Law\Queries;

use App\Models\Annotation;
use App\Models\Law;
use Tests\Http\GraphQL\AbstractHttpGraphQLTestCase;

class LawTest extends AbstractHttpGraphQLTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $law = Law::factory()->create([
            'id' => $this->createUUIDFromID(1),
        ]);

        $annotation = Annotation::factory()->create([
            'id' => $this->createUUIDFromID(1),
        ]);

        $law->annotations()->attach($annotation, [
            'cursor_index' => 111,
            'comment'      => 'This is a test comment!',
        ]);
    }

    /** @test */
    public function it_returns_a_law_by_id(): void
    {
        $this->graphQL(/** @lang GraphQL */ '
            query($id: UUID!) {
                law(id: $id) {
                    id
                    annotations {
                        id
                        pivot {
                            cursorIndex
                            comment
                        }
                    }
                }
            }
        ', [
            'id' => $this->createUUIDFromID(1),
        ])->assertJson([
            'data' => [
                'law' => [
                    'id'          => $this->createUUIDFromID(1),
                    'annotations' => [
                        [
                            'id'    => $this->createUUIDFromID(1),
                            'pivot' => [
                                'cursorIndex' => 111,
                                'comment'     => 'This is a test comment!',
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }

    /** @test */
    public function it_throws_a_validation_error_for_unknown_law_id(): void
    {
        $this->graphQL(/** @lang GraphQL */ '
            query($id: UUID!) {
                law(id: $id) {
                    id
                }
            }
        ', [
            'id' => $this->createUUIDFromID(222),
        ])->assertGraphQLValidationError('id', 'The selected id is invalid.');
    }
}
