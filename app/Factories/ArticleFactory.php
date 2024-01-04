<?php

namespace App\Factories;

use App\Contracts\Factories\ArticleFactoryInterface;
use App\Models\Article;
use App\Models\Law;
use PHPUnit\Util\Json;
use function Laravel\Prompts\text;

class ArticleFactory implements ArticleFactoryInterface
{

    public function create(Law $law, string $title, string $text, array $jsonData): Article
    {
        $jsonText = json_encode($jsonData);
        $article = new Article([
            'title' => $title,
            'text' => $text,
            'json_text' => $jsonText
        ]);
        $article->law()->associate($law);
        $article->save();
        return $article;
    }
}
