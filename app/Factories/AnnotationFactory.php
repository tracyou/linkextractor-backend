<?php

declare(strict_types=1);

namespace App\Factories;

use App\Contracts\Factories\AnnotationFactoryInterface;
use App\Models\Annotation;
use App\Models\Article;
use App\Models\Matter;
use App\Models\RelationSchema;

final class AnnotationFactory implements AnnotationFactoryInterface
{
    public function create(RelationSchema $schema, Article $article, Matter $matter, string $text): Annotation
    {
        $annotation = new Annotation([
            'text' => $text,
        ]);

        $annotation->relationSchema()->associate($schema);
        $annotation->article()->associate($article);
        $annotation->matter()->associate($matter);
        $annotation->save();

        return $annotation;
    }
}
