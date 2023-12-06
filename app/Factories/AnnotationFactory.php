<?php

namespace App\Factories;

use App\Models\Annotation;
use App\Models\Matter;

class AnnotationFactory
{
    public function create(Matter $matter, string $text): Annotation
    {
        $annotation = new Annotation([
            'text' => $text
        ]);
        $annotation->matter()->associate($matter);
        $annotation->save();
        return $annotation;
    }
}
