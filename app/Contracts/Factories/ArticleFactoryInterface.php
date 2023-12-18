<?php

declare(strict_types=1);

namespace App\Contracts\Factories;

use App\Models\Article;

interface ArticleFactoryInterface
{
    public function create(
        string $title,
        string $text,
        bool $isPublished,
    ): Article;
}
