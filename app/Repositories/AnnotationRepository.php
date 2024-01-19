<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Repositories\AnnotationRepositoryInterface;
use App\Models\Annotation;
use App\Models\Law;
use Wimski\ModelRepositories\Repositories\AbstractModelRepository;

/**
 * @extends AbstractModelRepository<Annotation>
 */
final class AnnotationRepository extends AbstractModelRepository implements AnnotationRepositoryInterface
{
    public function __construct(Annotation $model)
    {
        $this->model = $model;
    }
}
