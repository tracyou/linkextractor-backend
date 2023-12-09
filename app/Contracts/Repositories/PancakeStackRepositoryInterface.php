<?php

declare(strict_types=1);

namespace App\Contracts\Repositories;

use App\Models\PancakeStack;
use Wimski\ModelRepositories\Contracts\Repositories\ModelRepositoryInterface;

/**
 * @extends ModelRepositoryInterface<PancakeStack>
 */
interface PancakeStackRepositoryInterface extends ModelRepositoryInterface
{
}
