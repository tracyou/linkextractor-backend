<?php

namespace App\Factories;

use App\Contracts\Factories\Laws_annotationsFactoryInterface;
use App\Contracts\Factories\LawAnnotationsFactoryInterface;
use App\Models\LawAnnotation;

class LawAnnotationFactory implements LawAnnotationsFactoryInterface
{

    public function create(string $cursor_index): LawAnnotation
    {
        $lawAnnotation = new LawAnnotation();
        $lawAnnotation->cursor_index = $cursor_index;


        return $lawAnnotation;
    }
}
