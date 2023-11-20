<?php

namespace Tests\Http\GraphQL\Models\PancakeStack\Mutations;

use App\Models\Pancake;
use App\Models\PancakeStack;
use Tests\Http\GraphQL\AbstractHttpGraphQLTestCase;

class CreateTest extends AbstractHttpGraphQLTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        /** @var Pancake $pancake1 */
        $pancake1 = Pancake::factory()->create([ 'id' => 111 ]);
        /** @var Pancake $pancake2 */
        $pancake2 = Pancake::factory()->create([ 'id' => 222 ]);
        /** @var Pancake $pancake3 */
        $pancake3 = Pancake::factory()->create([ 'id' => 333 ]);
        /** @var Pancake $pancake4 */
        $pancake4 = Pancake::factory()->create([ 'id' => 444 ]);
        /** @var Pancake $pancake5 */
        $pancake5 = Pancake::factory()->create([ 'id' => 555 ]);

        /** @var PancakeStack $stack */
        $stack = PancakeStack::factory()->create([
            'name' => 'Test1',
        ]);

        $stack->pancakes()->saveMany([
            $pancake1,
            $pancake2,
            $pancake3,
            $pancake4,
            $pancake5,
        ]);
    }

    /**
     * @test
     */
    public function it_creates_a_pancake_stack(): void
    {
        $this->graphQL(/** @lang GraphQL */ '
            mutation {
                createPancakeStack(input: {
                    name: "New Pancake Stack",
                    pancakes: [111, 222, 444, 555]
                }) {
                    name
                    pancakes {
                        id
                    }
                }
            }
        ')->assertJson([
            'data' => [
                'createPancakeStack' => [
                    'name' => 'New Pancake Stack',
                    'pancakes' => [
                        [ 'id' => 111 ],
                        [ 'id' => 222 ],
                        [ 'id' => 444 ],
                        [ 'id' => 555 ],
                    ],
                ],
            ],
        ]);
    }

    /**
     * @test
     */
    public function it_throws_an_exception_for_non_existing_pancake_id(): void
    {
        $this->graphQL(/** @lang GraphQL */ '
            mutation {
                createPancakeStack(input: {
                    name: "New Pancake Stack",
                    pancakes: [111, 222, 444, 999]
                }) {
                    name
                    pancakes {
                        id
                    }
                }
            }
        ')->assertGraphQLValidationError('input.pancakes.3', 'The selected input.pancakes.3 is invalid.');
    }

    /**
     * @test
     */
    public function it_throws_an_exception_for_duplicate_stack_name(): void
    {
        $this->graphQL(/** @lang GraphQL */ '
            mutation {
                createPancakeStack(input: {
                    name: "Test1",
                    pancakes: [111, 222, 444, 999]
                }) {
                    name
                    pancakes {
                        id
                    }
                }
            }
        ')->assertGraphQLValidationError('input.name', 'The input.name has already been taken.');
    }
}
