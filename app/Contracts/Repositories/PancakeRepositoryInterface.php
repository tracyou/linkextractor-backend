<?php

declare(strict_types=1);

namespace App\Contracts\Repositories;

use App\Models\Pancake;
use Wimski\ModelRepositories\Contracts\Repositories\ModelRepositoryInterface;

/**
 * @extends ModelRepositoryInterface<Pancake>
 */
interface PancakeRepositoryInterface extends ModelRepositoryInterface
{
}
