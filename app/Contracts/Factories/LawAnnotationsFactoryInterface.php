<?php

namespace App\Contracts\Factories;

use App\Models\LawAnnotationPivot;

interface LawAnnotationsFactoryInterface
{
public function create(
    string $cursor_index
): LawAnnotationPivot;
}
