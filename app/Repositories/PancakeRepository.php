<?php

namespace App\Repositories;

use App\Contracts\Repositories\PancakeRepositoryInterface;
use App\Models\Pancake;
use Wimski\ModelRepositories\Repositories\AbstractModelRepository;

/**
 * @extends AbstractModelRepository<Pancake>
 */
class PancakeRepository extends AbstractModelRepository implements PancakeRepositoryInterface
{
    public function __construct(Pancake $model)
    {
        $this->model = $model;
    }
}
