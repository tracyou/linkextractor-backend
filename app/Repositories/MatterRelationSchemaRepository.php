<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Repositories\MatterRelationSchemaRepositoryInterface;
use App\Models\MatterRelationSchema;
use Wimski\ModelRepositories\Repositories\AbstractModelRepository;

/**
 * @extends AbstractModelRepository<MatterRelationSchema>
 */
class MatterRelationSchemaRepository extends AbstractModelRepository implements MatterRelationSchemaRepositoryInterface
{
    public function __construct(MatterRelationSchema $model)
    {
        $this->model = $model;
    }

    public function getMatterRelationSchema(string $relationSchemaId, string $matterId): MatterRelationSchema
    {
        return $this->model
            ->where('relation_schema_id', $relationSchemaId)
            ->where('matter_id', $matterId)
            ->first();
    }
}
