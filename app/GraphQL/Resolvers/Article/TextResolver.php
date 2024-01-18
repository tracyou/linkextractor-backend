<?php

declare(strict_types=1);

namespace App\GraphQL\Resolvers\Article;

use App\Models\Article;

class TextResolver
{
    public function __invoke(Article $root, array $args): string
    {
        return $root->text;
    }
}
