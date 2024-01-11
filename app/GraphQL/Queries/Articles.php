<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Models\Article;
use App\Contracts\Repositories\ArticleRepositoryInterface;
use App\Models\Annotation;
use App\Models\Law;
use Illuminate\Support\Collection;

class Articles
{
    public function __construct(
        protected ArticleRepositoryInterface $articleRepository,
    ) {
    }

    /**
     * @param array<string, mixed> $args
     *
     * @return Collection<int, Annotation>
     */
    public function __invoke(null $_, array $args): Collection
    {

        $articles = $this->articleRepository->all()->sortBy('title', SORT_NATURAL);

        return $articles;
    }
}
