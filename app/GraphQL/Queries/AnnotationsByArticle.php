<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Contracts\Repositories\ArticleRepositoryInterface;
use App\Models\Annotation;
use App\Models\Article;
use Illuminate\Support\Collection;

class AnnotationsByArticle
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
        $id = $args['article_id'];

        /** @var Article $article */
        $article = $this->articleRepository->findOrFail($id);

        return $article->annotations()->get();
    }
}
