<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Models\Article;
use App\Models\Annotation;
use Illuminate\Support\Collection;
use App\Contracts\Repositories\ArticleRepositoryInterface;

class ArticlesByLaw
{
    public function __construct(
        protected ArticleRepositoryInterface $articleRepository,
    ) {
    }

    /**
     * @param null                  $_
     * @param array<string, mixed>  $args
     *
     * @return array<int, Article>
     */
    public function __invoke(null $_, array $args): array
    {
        $id = $args['law_id'];

        return $this->articleRepository->where('law_id', $id)->sortBy('title', SORT_NATURAL)->toArray();
    }
}
