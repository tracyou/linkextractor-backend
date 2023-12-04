<?php

namespace App\Contracts\Factories;

use App\Models\LawAnnotationPivot;

interface LawAnnotationsPivotFactoryInterface
{
public function create(
    string $cursor_index
): LawAnnotationPivot;
}
