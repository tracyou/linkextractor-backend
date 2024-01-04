<?php

declare(strict_types=1);

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


    protected function graphQlJsonData(string $operation, array $data): array
    {
        return [
            'data' => [
                $operation => $data,
            ],
        ];
    }

    protected function createUUIDFromID(int $id): string
    {
        $hash = md5((string) $id);

        return sprintf(
            '%8s-%4s-%4s-%4s-%12s',
            substr($hash, 0, 8),
            substr($hash, 8, 4),
            substr($hash, 12, 4),
            substr($hash, 16, 4),
            substr($hash, 20, 12)
        );
    }
}
