<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Repositories\ArticleRevisionRepositoryInterface;
use App\Models\Article;
use App\Models\ArticleRevision;
use Illuminate\Support\Collection;
use Wimski\ModelRepositories\Repositories\AbstractModelRepository;

/**
 * @extends AbstractModelRepository<ArticleRevision>
 */
class ArticleRevisionRepository extends AbstractModelRepository implements ArticleRevisionRepositoryInterface
{
    public function __construct(ArticleRevision $model)
    {
        $this->model = $model;
    }

    public function getArticleRevision(Article $article, int $revision): ArticleRevision | null
    {
        return $this->model
            ->where('article_id', $article->getKey())
            ->where('revision', $revision)
            ->first();
    }
}
