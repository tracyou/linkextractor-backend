<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Contracts\Repositories\MatterRelationSchemaRepositoryInterface;

final class MatterRelationSchema
{
    public function __construct(
        protected MatterRelationSchemaRepositoryInterface $matterRelationSchemaRepository,
    ) {
    }

    /** @param array<string, mixed> $args */
    public function __invoke(null $_, array $args): \App\Models\MatterRelationSchema|null
    {
        $relationSchemaId = $args['relation_schema_id'];
        $matterId = $args['matter_id'];

        return $this->matterRelationSchemaRepository->getMatterRelationSchema($relationSchemaId, $matterId);
    }
}
