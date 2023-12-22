<?php

declare(strict_types=1);

namespace App\Factories;

use App\Contracts\Factories\MatterRelationSchemaFactoryInterface;
use App\Models\Matter;
use App\Models\MatterRelationSchema;
use App\Models\RelationSchema;

class MatterRelationSchemaFactory implements MatterRelationSchemaFactoryInterface
{
    public function create(Matter $matter, RelationSchema $relationSchema, string $schemaLayout): MatterRelationSchema
    {
        $schema = new MatterRelationSchema();
        $schema->schema_layout = $schemaLayout;

        $schema->matter()->associate($matter);
        $schema->relationSchema()->associate($relationSchema);

        $schema->save();

        return $schema;
    }
}
