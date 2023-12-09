<?php

namespace Tests\Http\GraphQL;

use Illuminate\Foundation\Testing\TestCase;
use Nuwave\Lighthouse\Testing\MakesGraphQLRequests;
use Tests\Traits\CreatesApplication;
use Tests\Traits\UsesDatabase;

abstract class AbstractHttpGraphQLTestCase extends TestCase
{
    use CreatesApplication;
    use MakesGraphQLRequests;
    use UsesDatabase;

    /**
     * @param mixed[] $data
     *
     * @return mixed[]
     */
    protected function graphQlJsonData(string $operation, array $data): array
    {
        return [
            'data' => [
                $operation => $data,
            ],
        ];
    }
}
