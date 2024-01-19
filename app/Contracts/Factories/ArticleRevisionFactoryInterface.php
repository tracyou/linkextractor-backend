<?php

namespace App\Contracts\Factories;

use App\Models\Article;
use App\Models\ArticleRevision;
use App\Models\Law;

interface ArticleRevisionFactoryInterface
{
    public function create(Article $article, ?array $jsonData = []): ArticleRevision;
}
