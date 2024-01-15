<?php

declare(strict_types=1);

namespace Tests\Http\GraphQL\Enums\MatterRelationEnum\Queries;

use App\Enums\MatterRelationEnum;
use Tests\Http\GraphQL\AbstractHttpGraphQLTestCase;

class MatterRelationTypesTest extends AbstractHttpGraphQLTestCase
{
    /** @test */
    public function it_returns_matter_relation_types(): void
    {
        $outcome = [];
        foreach (MatterRelationEnum::asArray() as $value) {
            $outcome[] = [
                'key'   => MatterRelationEnum::fromValue($value)->key,
                'value' => $value,
            ];
        }

        $this->graphQL(/** @lang GraphQL */ '
            query {
                matterRelationTypes {
                    key
                    value
                }
            }
        ')->assertJson([
            'data' => [
                'matterRelationTypes' => $outcome,
            ],
        ]);
    }
}
