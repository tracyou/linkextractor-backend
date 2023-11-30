<?php

namespace App\Contracts\Factories;

use App\Models\LawAnnotation;

interface LawAnnotationsFactoryInterface
{
public function create(
    string $cursor_index
): LawAnnotation;
}
