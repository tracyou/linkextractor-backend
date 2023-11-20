<?php

namespace App\Repositories;

use App\Contracts\Repositories\PancakeStackRepositoryInterface;
use App\Models\PancakeStack;
use Wimski\ModelRepositories\Repositories\AbstractModelRepository;

/**
 * @extends AbstractModelRepository<PancakeStack>
 */
class PancakeStackRepository extends AbstractModelRepository implements PancakeStackRepositoryInterface
{
    public function __construct(PancakeStack $model)
    {
        $this->model = $model;
    }
}
