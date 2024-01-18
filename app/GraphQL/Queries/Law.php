<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Contracts\Repositories\ArticleRepositoryInterface;
use App\Contracts\Repositories\ArticleRevisionRepositoryInterface;
use App\Contracts\Repositories\LawRepositoryInterface;
use App\Contracts\Repositories\MatterRelationSchemaRepositoryInterface;
use App\Models\Article;

class Law
{
    public function __construct(
        protected LawRepositoryInterface $lawRepository,
        protected ArticleRepositoryInterface $articleRepository,
        protected ArticleRevisionRepositoryInterface $articleRevisionRepository,
    ) {
    }

    /** @param array<string, mixed> $args */
    public function __invoke(null $_, array $args): \App\Models\Law | null
    {
        $lawId = $args['id'];
        $revision = $args['revision'] ?? 0;

        /** @var \App\Models\Law $law */
        $law = $this->lawRepository->findOrFail($lawId);

        $law->articles->map(function (Article $article) use ($revision) {
            $article->revision = $this->articleRevisionRepository->getArticleRevision($article, $revision);
        });

        return $law;
    }
}
