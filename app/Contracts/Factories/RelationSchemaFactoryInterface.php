<?php

declare(strict_types=1);

namespace App\Contracts\Factories;

use App\Models\RelationSchema;

interface RelationSchemaFactoryInterface
{
    public function create(bool $isPublished): RelationSchema;
}
