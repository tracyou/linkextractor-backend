<?php

declare(strict_types=1);

namespace App\Factories;

use App\Contracts\Factories\ArticleFactoryInterface;
use App\Models\Article;

final class ArticleFactory implements ArticleFactoryInterface
{
    public function create(string $title, string $text, bool $isPublished): Article
    {
        $article = new Article();
        $article->title = $title;
        $article->text = $text;

        $article->save();

        return $article;
    }
}
