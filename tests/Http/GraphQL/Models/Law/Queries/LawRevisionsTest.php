<?php

declare(strict_types=1);

namespace Http\GraphQL\Models\Law\Queries;

use App\Models\Article;
use App\Models\ArticleRevision;
use App\Models\Law;
use Carbon\Carbon;
use Tests\Http\GraphQL\AbstractHttpGraphQLTestCase;

class LawRevisionsTest extends AbstractHttpGraphQLTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Carbon::setTestNow('2021-01-01 00:00:00');

        $law = Law::factory()->create([
            'id'       => $this->createUUIDFromID(1),
            'revision' => 0,
        ]);

        Article::factory()->create([
            'id'     => $this->createUUIDFromID(1),
            'law_id' => $this->createUUIDFromID(1),
        ]);

        $this->createRevision($law, 1, '2021-01-02 00:00:00');
        $this->createRevision($law, 2, '2021-01-03 00:00:00');
        $this->createRevision($law, 3, '2021-01-04 00:00:00');
    }

    /** @test */
    public function it_returns_all_law_revisions_for_given_law(): void
    {
        $this->graphQL(/** @lang GraphQL */ '
            query($id: UUID!) {
                lawRevisions(id: $id) {
                    law {
                        id
                    }
                    revisions {
                        revision
                        createdAt
                    }
                }
            }
        ', [
            'id' => $this->createUUIDFromID(1),
        ])->assertJson([
            'data' => [
                'lawRevisions' => [
                    'law'       => [
                        'id' => $this->createUUIDFromID(1),
                    ],
                    'revisions' => [
                        [
                            'revision'  => 1,
                            'createdAt' => '2021-01-02 00:00:00',
                        ],
                        [
                            'revision'  => 2,
                            'createdAt' => '2021-01-03 00:00:00',
                        ],
                        [
                            'revision'  => 3,
                            'createdAt' => '2021-01-04 00:00:00',
                        ],
                    ],
                ],
            ],
        ]);
    }

    protected function createRevision(Law $law, int $revision, string $createdAt): void
    {
        Carbon::setTestNow($createdAt);

        ArticleRevision::factory()->createQuietly([
            'id'         => $this->createUUIDFromID($revision),
            'article_id' => $this->createUUIDFromID(1),
            'revision'   => $revision,
        ]);

        $law->update([
            'revision' => $revision,
        ]);
    }
}
