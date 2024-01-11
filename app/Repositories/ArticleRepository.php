<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Article;
use App\Contracts\Repositories\ArticleRepositoryInterface;
use Wimski\ModelRepositories\Repositories\AbstractModelRepository;

final class ArticleRepository extends AbstractModelRepository implements ArticleRepositoryInterface
{
    public function __construct(Article $model)
    {
        $this->model = $model;
    }


}
