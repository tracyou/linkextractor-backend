<?php

declare(strict_types=1);

namespace App\Contracts\Factories;

use App\Models\Annotation;
use App\Models\ArticleRevision;
use App\Models\Matter;
use App\Models\RelationSchema;

interface AnnotationFactoryInterface
{
    public function create(
        Matter $matter,
        string $text,
        ?string $definition,
        ?string $comment,
        ArticleRevision $articleRevision,
        RelationSchema $schema
    ): Annotation;
}
