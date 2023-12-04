<?php

namespace App\Repositories;

use App\Contracts\Repositories\LawRepositoryInterface;
use App\Models\Law;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\LazyCollection;
use Wimski\ModelRepositories\Repositories\AbstractModelRepository;

class LawRepository extends AbstractModelRepository implements LawRepositoryInterface
{

public function __construct(Law $model)
{
    $this->model = $model;
}
}
