<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Repositories\MatterRepositoryInterface;
use App\Models\Matter;
use Wimski\ModelRepositories\Repositories\AbstractModelRepository;

/**
 * @extends AbstractModelRepository<Matter>
 */
final class MatterRepository extends AbstractModelRepository implements MatterRepositoryInterface
{
    public function __construct(Matter $model)
    {
        $this->model = $model;
    }
}
