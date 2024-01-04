<?php

declare(strict_types=1);

namespace App\Contracts\Factories;

use App\Models\Article;
use App\Models\Law;

interface ArticleFactoryInterface
{
    public function create(
        Law $law,
        string $title,
        string $text,
        bool $isPublished,
    ): Article;
}
