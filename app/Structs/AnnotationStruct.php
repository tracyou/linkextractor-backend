<?php

declare(strict_types=1);

namespace App\Structs;

use App\Models\Article;
use App\Models\Matter;

class AnnotationStruct
{
    public function __construct(
        public string $tempId,
        public Matter $matter,
        public string $text,
        public ?string $definition,
        public ?string $comment,
        public Article $article,
    ) {
    }
}
