<?php

declare(strict_types=1);

namespace App\Factories;

use App\Contracts\Factories\RelationSchemaFactoryInterface;
use App\Models\RelationSchema;

class RelationSchemaFactory implements RelationSchemaFactoryInterface
{
    public function create(bool $isPublished): RelationSchema
    {
        $schema = new RelationSchema();
        $schema->is_published = $isPublished;

        $schema->save();

        return $schema;
    }
}
