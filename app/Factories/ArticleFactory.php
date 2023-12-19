<?php

namespace App\Factories;

use App\Contracts\Factories\AtrticleFactoryInterface;
use App\Models\Article;
use App\Models\Law;
use Psy\Util\Json;
use function Laravel\Prompts\text;

class ArticleFactory implements AtrticleFactoryInterface
{

    public function create(Law $law, string $title, Json $text): Article
    {
        $article = new Article();

        $article->title = $title;
        $article->text = $text;
        $article->law->save([$law]);

        return $article;
    }
}
