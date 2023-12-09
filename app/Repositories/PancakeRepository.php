<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Repositories\PancakeRepositoryInterface;
use App\Models\Pancake;
use Wimski\ModelRepositories\Repositories\AbstractModelRepository;

/**
 * @extends AbstractModelRepository<Pancake>
 */
final class PancakeRepository extends AbstractModelRepository implements PancakeRepositoryInterface
{
    public function __construct(Pancake $model)
    {
        $this->model = $model;
    }
}
