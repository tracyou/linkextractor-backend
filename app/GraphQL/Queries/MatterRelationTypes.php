<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Enums\MatterRelationEnum;

class MatterRelationTypes
{
    /**
     * @param null                  $_
     * @param array<string, string> $args
     *
     * @return array<int, array<string, mixed>>
     */
    public function __invoke(null $_, array $args): array
    {
        $statuses = [];

        foreach (MatterRelationEnum::asArray() as $value) {
            $statuses[] = [
                'key'   => $value,
                'value' => $value,
            ];
        }

        return $statuses;
    }
}
