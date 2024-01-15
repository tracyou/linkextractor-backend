<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Repositories\LawRepositoryInterface;
use App\Models\Law;
use Wimski\ModelRepositories\Repositories\AbstractModelRepository;

final class LawRepository extends AbstractModelRepository implements LawRepositoryInterface
{
    public function __construct(Law $model)
    {
        $this->model = $model;
    }
}
