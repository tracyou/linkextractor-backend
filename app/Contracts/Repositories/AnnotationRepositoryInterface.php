<?php

declare(strict_types=1);

namespace App\Contracts\Repositories;

use App\Models\Annotation;
use App\Models\Law;
use Wimski\ModelRepositories\Contracts\Repositories\ModelRepositoryInterface;

/**
 * @extends ModelRepositoryInterface<Annotation>
 */
interface AnnotationRepositoryInterface extends ModelRepositoryInterface
{
}
