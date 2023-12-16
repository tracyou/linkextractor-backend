<?php

namespace App\Repositories;

use App\Contracts\Repositories\FileXmlRepositoryInterface;
use App\Models\FileXml;
use Wimski\ModelRepositories\Repositories\AbstractModelRepository;

class FileXmlRepository extends AbstractModelRepository implements FileXmlRepositoryInterface
{

    public function __construct(FileXml $model)
    {
        $this->model = $model;
    }
}
