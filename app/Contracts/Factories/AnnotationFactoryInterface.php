<?php

declare(strict_types=1);

namespace App\Contracts\Factories;

use App\Models\Annotation;
use App\Models\Article;
use App\Models\Matter;
use App\Models\RelationSchema;

interface AnnotationFactoryInterface
{
    public function create(
        Article $article,
        RelationSchema $relationSchema,
        Matter $matter,
        string $text,
        ?string $definition,
        ?string $comment,
    ): Annotation;
}
