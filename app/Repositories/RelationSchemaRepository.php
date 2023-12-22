<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Repositories\RelationSchemaRepositoryInterface;
use App\Models\RelationSchema;
use Wimski\ModelRepositories\Repositories\AbstractModelRepository;

/**
 * @extends AbstractModelRepository<RelationSchema>
 */
class RelationSchemaRepository extends AbstractModelRepository implements RelationSchemaRepositoryInterface
{
    public function __construct(RelationSchema $model)
    {
        $this->model = $model;
    }
}
