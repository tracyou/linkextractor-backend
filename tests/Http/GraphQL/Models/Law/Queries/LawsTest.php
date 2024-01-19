<?php

declare(strict_types=1);

namespace Tests\Http\GraphQL\Models\Law\Queries;

use App\Models\Annotation;
use App\Models\Article;
use App\Models\ArticleRevision;
use App\Models\Law;
use Tests\Http\GraphQL\AbstractHttpGraphQLTestCase;

class LawsTest extends AbstractHttpGraphQLTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Law::factory()->createMany([
            [
                'id' => $this->createUUIDFromID(1),
            ],
            [
                'id'   => $this->createUUIDFromID(2),
            ],
            [
                'id'   => $this->createUUIDFromID(3),
            ],
        ]);
    }

    /**
     * @test
     */
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
}
