<?php

declare(strict_types=1);

namespace App\Contracts\Repositories;

use App\Models\MatterRelationSchema;
use Illuminate\Support\Collection;
use Wimski\ModelRepositories\Contracts\Repositories\ModelRepositoryInterface;

/**
 * @extends ModelRepositoryInterface<MatterRelationSchema>
 */
interface MatterRelationSchemaRepositoryInterface extends ModelRepositoryInterface
{
    public function getMatterRelationSchema(string $relationSchemaId, string $matterId): MatterRelationSchema|null;

    /**
     * @return Collection<MatterRelationSchema>
     */
    public function getMatterRelationSchemasForRelationSchema(string $relationSchemaId): Collection;
}
