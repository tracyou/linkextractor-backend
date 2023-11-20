<?php

namespace Tests\Http\GraphQL\Models\PancakeStack\Queries;

use App\Models\Pancake;
use App\Models\PancakeStack;
use Tests\Http\GraphQL\AbstractHttpGraphQLTestCase;

class PancakeStacksTest extends AbstractHttpGraphQLTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        /** @var Pancake $pancake1 */
        $pancake1 = Pancake::factory()->create([
            'id' => 111,
        ]);

        /** @var Pancake $pancake2 */
        $pancake2 = Pancake::factory()->create([
            'id' => 222,
        ]);

        /** @var Pancake $pancake3 */
        $pancake3 = Pancake::factory()->create([
            'id' => 333,
        ]);

        /** @var Pancake $pancake4 */
        $pancake4 = Pancake::factory()->create([
            'id' => 444,
        ]);

        /** @var Pancake $pancake5 */
        $pancake5 = Pancake::factory()->create([
            'id' => 555,
        ]);

        /** @var PancakeStack $stack1 */
        $stack1 = PancakeStack::factory()->create([
            'id' => 111,
        ]);

        /** @var PancakeStack $stack2 */
        $stack2 = PancakeStack::factory()->create([
            'id' => 222,
        ]);

        /** @var PancakeStack $stack3 */
        $stack3 = PancakeStack::factory()->create([
            'id' => 333,
        ]);

        $stack1->pancakes()->saveMany([$pancake1, $pancake2]);
        $stack2->pancakes()->saveMany([$pancake3, $pancake4]);
        $stack3->pancakes()->saveMany([$pancake5]);
    }

    /**
     * @test
     */
    public function it_returns_all_pancake_stacks(): void
    {
        $this->graphQL(/** @lang GraphQL */ '
            query {
                pancakeStacks {
                    id
                    pancakes {
                        id
                    }
                }
            }
        ')->assertJson([
            'data' => [
                'pancakeStacks' => [
                    [
                        'id' => 111,
                        'pancakes' => [
                            [
                                'id' => 111,
                            ],
                            [
                                'id' => 222,
                            ],
                        ],
                    ],
                    [
                        'id' => 222,
                        'pancakes' => [
                            [
                                'id' => 333,
                            ],
                            [
                                'id' => 444,
                            ],
                        ],
                    ],
                    [
                        'id' => 333,
                        'pancakes' => [
                            [
                                'id' => 555,
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }
}
