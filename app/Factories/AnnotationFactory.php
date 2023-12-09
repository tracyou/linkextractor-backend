<?php

declare(strict_types=1);

namespace App\Factories;

use App\Contracts\Factories\AnnotationFactoryInterface;
use App\Models\Annotation;
use App\Models\Matter;

final class AnnotationFactory implements AnnotationFactoryInterface
{
    public function create(Matter $matter, string $text): Annotation
    {
        $annotation = new Annotation([
            'text' => $text,
        ]);
        $annotation->matter()->associate($matter);
        $annotation->save();

        return $annotation;
    }
}
