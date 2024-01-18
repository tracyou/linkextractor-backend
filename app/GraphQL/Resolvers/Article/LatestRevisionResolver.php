<?php

declare(strict_types=1);

namespace App\GraphQL\Resolvers\Article;

use App\Models\Article;
use App\Models\ArticleRevision;

class LatestRevisionResolver
{
    public function __invoke(Article $root, array $args): ArticleRevision | null
    {
        return $root->revisions->last();
    }
}
