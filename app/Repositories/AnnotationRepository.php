<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Repositories\AnnotationRepositoryInterface;
use App\Models\Annotation;
use Wimski\ModelRepositories\Repositories\AbstractModelRepository;

/**
 * @extends AbstractModelRepository<Annotation>
 */
class AnnotationRepository extends AbstractModelRepository implements AnnotationRepositoryInterface
{
    public function __construct(Annotation $model)
    {
        $this->model = $model;
    }
}