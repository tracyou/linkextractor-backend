<?php

namespace App\Contracts\Factories;

use App\Models\Annotation;
use App\Models\Matter;

interface AnnotationFactoryInterface
{
    public function create(Matter $matter, string $text): Annotation;
}
