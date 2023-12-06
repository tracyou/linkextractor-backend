<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Repositories\MatterRelationRepositoryInterface;
use App\Models\MatterRelation;
use Wimski\ModelRepositories\Repositories\AbstractModelRepository;

/**
 * @extends AbstractModelRepository<MatterRelation>
 */
class MatterRelationRepository extends AbstractModelRepository implements MatterRelationRepositoryInterface
{
    public function __construct(MatterRelation $model)
    {
        $this->model = $model;
    }
}
