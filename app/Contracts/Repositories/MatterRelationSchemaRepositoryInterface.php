<?php

declare(strict_types=1);

namespace App\Contracts\Repositories;

use App\Models\MatterRelationSchema;
use Wimski\ModelRepositories\Contracts\Repositories\ModelRepositoryInterface;

/**
 * @extends ModelRepositoryInterface<MatterRelationSchema>
 */
interface MatterRelationSchemaRepositoryInterface extends ModelRepositoryInterface
{
}
