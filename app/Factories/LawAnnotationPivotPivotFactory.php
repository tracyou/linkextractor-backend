<?php

namespace App\Factories;

use App\Contracts\Factories\LawAnnotationsPivotFactoryInterface;
use App\Models\LawAnnotationPivot;

class LawAnnotationPivotPivotFactory implements LawAnnotationsPivotFactoryInterface
{

    public function create(string $cursor_index): LawAnnotationPivot
    {
        $lawAnnotation = new LawAnnotationPivot();
        $lawAnnotation->cursorIndex = $cursor_index;


        return $lawAnnotation;
    }
}
