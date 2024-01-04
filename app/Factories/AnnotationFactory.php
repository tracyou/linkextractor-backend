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
    public function create(
        RelationSchema $schema,
        Article $article,
        Matter $matter,
        string $text,
        ?string $definition,
        ?string $comment,
    ): Annotation {
        $annotation = new Annotation();
        $annotation->text = $text;
        $annotation->definition = $definition;
        $annotation->comment = $comment;

        $annotation->relationSchema()->associate($schema);
        $annotation->matter()->associate($matter);
        $annotation->article()->associate($article);
        $annotation->save();

        return $annotation;
    }
}
