<?php

declare(strict_types=1);

namespace App\GraphQL\Resolvers\Law;

use App\Models\Law;
use Illuminate\Support\Collection;

class ArticlesResolver
{
    public function __invoke(Law $root, array $args): Collection
    {
        return $root->articles->sortBy('title', SORT_NATURAL);
    }
}
