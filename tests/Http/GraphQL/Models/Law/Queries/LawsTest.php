<?php

declare(strict_types=1);

namespace Http\GraphQL\Models\Law\Queries;

use App\Models\Article;
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
        Article::factory()->create([
            'law_id' => $law->id,
            'title'  => 'Artikel 1',
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
                    articles {
                        title
                    }
                }
            }
        ')->assertJson([
            'data' => [
                'laws' => [
                    [
                        'id'       => $this->createUUIDFromID(1),
                        'articles' => [[
                            'title' => 'Artikel 1',
                        ]],
                    ],
                    [
                        'id'       => $this->createUUIDFromID(2),
                        'articles' => [],
                    ],
                    [
                        'id'       => $this->createUUIDFromID(3),
                        'articles' => [],
                    ],
                ],
            ],
        ]);
    }
}
