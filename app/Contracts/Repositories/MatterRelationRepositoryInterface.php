<?php

declare(strict_types=1);

namespace App\Contracts\Repositories;

use App\Models\MatterRelation;
use Wimski\ModelRepositories\Contracts\Repositories\ModelRepositoryInterface;

/**
 * @extends ModelRepositoryInterface<MatterRelation>
 */
interface MatterRelationRepositoryInterface extends ModelRepositoryInterface
{
}
