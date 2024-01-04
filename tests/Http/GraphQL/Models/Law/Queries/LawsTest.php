<?php

declare(strict_types=1);

namespace Http\GraphQL\Models\Law\Queries;

use App\Models\Annotation;
use App\Models\Law;
use Tests\Http\GraphQL\AbstractHttpGraphQLTestCase;

class LawsTest extends AbstractHttpGraphQLTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $law = Law::factory()->create([
            'id' => $this->createUUIDFromID(1),
        ]);

        Law::factory()->createMany([
            [
                'id' => $this->createUUIDFromID(2),
            ],
            [
                'id' => $this->createUUIDFromID(3),
            ],
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
    public function it_returns_all_laws(): void
    {
        $this->graphQL(/** @lang GraphQL */ '
            query {
                laws {
                    id
                }
            }
        ')->assertJson([
            'data' => [
                'laws' => [
                    ['id' => $this->createUUIDFromID(1)],
                    ['id' => $this->createUUIDFromID(2)],
                    ['id' => $this->createUUIDFromID(3)],
                ],
            ],
        ]);
    }

    /** @test */
    public function it_returns_pivot_attributes_with_annotations(): void
    {
        $this->graphQL(/** @lang GraphQL */ '
            query {
                laws {
                    id
                    annotations {
                        pivot {
                            cursorIndex
                            comment
                        }
                    }
                }
            }
        ')->assertJson([
            'data' => [
                'laws' => [
                    [
                        'id'          => $this->createUUIDFromID(1),
                        'annotations' => [
                            [
                                'pivot' => [
                                    'cursorIndex' => 111,
                                    'comment'     => 'This is a test comment!',
                                ],
                            ],
                        ],
                    ],
                    [
                        'id'          => $this->createUUIDFromID(2),
                        'annotations' => [],
                    ],
                    [
                        'id'          => $this->createUUIDFromID(3),
                        'annotations' => [],
                    ],
                ],
            ],
        ]);
    }
}
