<?php

namespace App\Factories;

use App\Contracts\Factories\AtrticleFactoryInterface;
use App\Models\Article;
use App\Models\Law;
use Psy\Util\Json;
use function Laravel\Prompts\text;

class ArticleFactory implements AtrticleFactoryInterface
{

    public function create(Law $law, string $title, string $text): Article
    {
        $article = new Article([
            'title' => 'title of the article',
            'text' => 'this is the text of the article',
        ]);
        $article->law()->associate($law);
        $article->save();
        return $article;
    }
}
