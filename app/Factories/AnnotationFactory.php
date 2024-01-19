<?php

declare(strict_types=1);

namespace App\Factories;

use App\Contracts\Factories\AnnotationFactoryInterface;
use App\Models\Annotation;
use App\Models\ArticleRevision;
use App\Models\Matter;
use App\Models\RelationSchema;

final class AnnotationFactory implements AnnotationFactoryInterface
{
    public function create(
        Matter $matter,
        string $text,
        ?string $definition,
        ?string $comment,
        ArticleRevision $articleRevision,
        RelationSchema $schema
    ): Annotation {
        $annotation = new Annotation([
            'text'       => $text,
            'definition' => $definition,
            'comment'    => $comment,
        ]);

        $annotation->relationSchema()->associate($schema);
        $annotation->matter()->associate($matter);
        $annotation->articleRevision()->associate($articleRevision);

        $annotation->save();

        return $annotation;
    }
}
