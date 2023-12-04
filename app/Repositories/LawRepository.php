<?php

namespace App\Repositories;

use App\Contracts\Repositories\LawsRepositoryInterface;
use App\Models\Law;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\LazyCollection;
use Wimski\ModelRepositories\Repositories\AbstractModelRepository;

class LawRepository extends AbstractModelRepository implements LawsRepositoryInterface
{
    public function __construct(Law $model)
    {
        $this->model = $model;
    }


}
