<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Contracts\Repositories\ArticleRepositoryInterface;
use App\Models\Article;

class ArticlesByLaw
{
    public function __construct(
        protected ArticleRepositoryInterface $articleRepository,
    ) {
    }

    /**
     * @param array<string, mixed> $args
     *
     * @return array<int, Article>
     */
    public function __invoke(null $_, array $args): array
    {
        $id = $args['law_id'];

        return $this->articleRepository->where('law_id', $id)->sortBy('id')->toArray();
    }
}
