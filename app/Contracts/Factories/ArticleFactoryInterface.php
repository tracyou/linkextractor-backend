<?php

namespace App\Contracts\Factories;

use App\Models\Article;
use App\Models\Law;
use Psy\Util\Json;

interface ArticleFactoryInterface
{
    public function create(Law $law, string $title, string $text): Article;

}
