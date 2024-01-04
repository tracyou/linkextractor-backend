<?php

namespace App\Factories;

use App\Contracts\Factories\ArticleFactoryInterface;
use App\Models\Article;
use App\Models\Law;
use Psy\Util\Json;
use function Laravel\Prompts\text;

class ArticleFactory implements ArticleFactoryInterface
{

    public function create(Law $law, string $title, string $text): Article
    {
        $article = new Article([
            'title' => $title,
            'text' => $text,
        ]);
        $article->law()->associate($law);
        $article->save();
        return $article;
    }
}
