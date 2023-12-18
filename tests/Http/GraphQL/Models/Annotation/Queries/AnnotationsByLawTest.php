<?php

declare(strict_types=1);

namespace Http\GraphQL\Models\Annotation\Queries;

use App\Models\Annotation;
use App\Models\Law;
use App\Models\Matter;
use Tests\Http\GraphQL\AbstractHttpGraphQLTestCase;

class AnnotationsByLawTest extends AbstractHttpGraphQLTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $matter1 = Matter::factory()->create([
            'id' => $this->createUUIDFromID(1),
        ]);

        $annotation1 = Annotation::factory()->create([
            'id'        => $this->createUUIDFromID(1),
            'matter_id' => $matter1->getKey(),
        ]);

        $matter2 = Matter::factory()->create([
            'id' => $this->createUUIDFromID(2),
        ]);

        $annotation2 = Annotation::factory()->create([
            'id'        => $this->createUUIDFromID(2),
            'matter_id' => $matter2->getKey(),
        ]);

        $law = Law::factory()->create([
            'id' => $this->createUUIDFromID(1),
        ]);

        $law->annotations()->attach($annotation1->getKey(), [
            'cursor_index' => 111,
            'comment'      => 'This is a test comment!',
        ]);

        $law->annotations()->attach($annotation2->getKey(), [
            'cursor_index' => 222,
            'comment'      => 'This is another test comment!',
        ]);
    }

    /**
     * @test
     */
    public function it_returns_all_annotations_for_given_law(): void
    {
        $this->graphQL(/** @lang GraphQL */ '
            query($id: UUID!) {
                annotationsByLaw(lawId: $id) {
                    id
                    pivot {
                        cursorIndex
                        comment
                    }
                    matter {
                        id
                    }
                }
            }
        ',
            [
                'id' => $this->createUUIDFromID(1),
            ]
        )->assertJson([
            'data' => [
                'annotationsByLaw' => [
                    [
                        'id' => $this->createUUIDFromID(1),
                        'pivot' => [
                            'cursorIndex' => 111,
                            'comment' => 'This is a test comment!',
                        ],
                        'matter' => [
                            'id' => $this->createUUIDFromID(1),
                        ],
                    ],
                    [
                        'id' => $this->createUUIDFromID(2),
                        'pivot' => [
                            'cursorIndex' => 222,
                            'comment' => 'This is another test comment!',
                        ],
                        'matter' => [
                            'id' => $this->createUUIDFromID(2),
                        ],
                    ],
                ],
            ],
        ]);
    }

    /**
     * @test
     */
    public function it_throws_a_validation_error_for_non_existing_law_id(): void
    {
        $this->graphQL(/** @lang GraphQL */ '
            query($id: UUID!) {
                annotationsByLaw(lawId: $id) {
                    id
                }
            }
        ',
            [
                'id' => $this->createUUIDFromID(4),
            ]
        )->assertGraphQLValidationError('lawId', 'The selected law id is invalid.');
    }
}
