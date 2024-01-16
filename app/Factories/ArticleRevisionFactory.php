<?php

declare(strict_types=1);

namespace App\Factories;

use App\Contracts\Factories\ArticleRevisionFactoryInterface;
use App\Models\Article;
use App\Models\ArticleRevision;

class ArticleRevisionFactory implements ArticleRevisionFactoryInterface
{
    public function create(Article $article, ?array $jsonData): ArticleRevision
    {
        $jsonText = json_encode($jsonData);

        $revision = new ArticleRevision();
        $revision->json_text = $jsonText;
        $revision->article()->associate($article);

        $revision->save();

        return $revision;
    }
}
