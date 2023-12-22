<?php

declare(strict_types=1);

namespace App\Contracts\Factories;

use App\Models\Matter;
use App\Models\MatterRelationSchema;
use App\Models\RelationSchema;

interface MatterRelationSchemaFactoryInterface
{
    public function create(Matter $matter, RelationSchema $relationSchema, string $schemaLayout): MatterRelationSchema;
}
