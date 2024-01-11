<?php

declare(strict_types=1);

namespace Http\GraphQL\Models\Law\Queries;

use App\Models\Article;
use App\Models\Annotation;
use App\Models\Law;
use Tests\Http\GraphQL\AbstractHttpGraphQLTestCase;

class LawTest extends AbstractHttpGraphQLTestCase
{
    /** @test */
    public function it_returns_a_law_by_id(): void
    {
        $this->graphQL(/** @lang GraphQL */ '
            query($id: UUID!) {
                law(id: $id) {
                    id
                    articles {
                        text
                    }
                }
            }
        ', [
            'id' => $this->createUUIDFromID(1),
        ])->assertJson([
            'data' => [
                'law' => [
                    'id'       => $this->createUUIDFromID(1),
                    'articles' => [
                        ['text' => 'This is a test comment!'],
                        ['text' => 'This is a test comment!'],
                        ['text' => 'This is a test comment!'],
                        ['text' => 'This is a test comment!'],
                        ['text' => 'This is a test comment!'],
                        ['text' => 'This is a test comment!'],
                        ['text' => 'This is a test comment!'],
                        ['text' => 'This is a test comment!'],
                        ['text' => 'This is a test comment!'],
                        ['text' => 'This is a test comment!'],
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

    protected function setUp(): void
    {
        parent::setUp();

        $law = Law::factory()->create([
            'id' => $this->createUUIDFromID(1),
        ]);

        Article::factory(10)->create([
            'law_id' => $law->id,
            'text'   => 'This is a test comment!',
        ]);

    }
}
