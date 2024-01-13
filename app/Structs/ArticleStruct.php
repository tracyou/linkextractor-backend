<?php

namespace App\Structs;

use App\Models\Article;
use Illuminate\Support\Str;

final class ArticleStruct
{
    public function __construct(
        public ?string $label = null,
        public ?string $nr = null,
        public ?string $titel = null,
        public ?string $text = null,
    ) {
    }

    public function toModel(): ?Article
    {
        $article = new Article();
        $article->id = Str::orderedUuid();
        $article->title = $this->label . ' ' . $this->nr . ' ' . $this->titel;
        $article->text = $this->text ?: '';

        return $article;
    }
}
