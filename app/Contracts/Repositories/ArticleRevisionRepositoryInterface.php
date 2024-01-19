<?php

declare(strict_types=1);

namespace App\Contracts\Repositories;

use App\Models\Article;
use App\Models\ArticleRevision;
use Illuminate\Support\Collection;
use Wimski\ModelRepositories\Contracts\Repositories\ModelRepositoryInterface;

/**
 * @extends ModelRepositoryInterface<ArticleRevision>
 */
interface ArticleRevisionRepositoryInterface extends ModelRepositoryInterface
{
    public function getArticleRevision(Article $article, int $revision): ArticleRevision | null;
}
