<?php

namespace App\Structs;

use App\Models\Article;

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
        $law = new Article();
        $law->title = $this->label . ' ' . $this->nr . ' ' . $this->titel;
        if (!$this->text) {
            return null;
        }
        $law->text = $this->text;

        return $law;
    }
}
