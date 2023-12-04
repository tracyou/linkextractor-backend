<?php

namespace App\Factories;

use App\Contracts\Factories\Laws_annotationsFactoryInterface;
use App\Contracts\Factories\LawAnnotationsFactoryInterface;
use App\Models\LawAnnotationPivot;

class LawAnnotationFactory implements LawAnnotationsFactoryInterface
{

    public function create(string $cursor_index): LawAnnotationPivot
    {
        $lawAnnotation = new LawAnnotationPivot();
        $lawAnnotation->cursor_index = $cursor_index;


        return $lawAnnotation;
    }
}
