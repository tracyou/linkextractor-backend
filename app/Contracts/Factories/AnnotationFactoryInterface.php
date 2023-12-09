<?php

declare(strict_types=1);

namespace App\Contracts\Factories;

use App\Models\Annotation;
use App\Models\Matter;

interface AnnotationFactoryInterface
{
    public function create(Matter $matter, string $text): Annotation;
}
