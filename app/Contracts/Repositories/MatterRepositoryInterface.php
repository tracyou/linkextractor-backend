<?php

declare(strict_types=1);

namespace App\Contracts\Repositories;

use App\Models\Matter;
use Wimski\ModelRepositories\Contracts\Repositories\ModelRepositoryInterface;

/**
 * @extends ModelRepositoryInterface<Matter>
 */
interface MatterRepositoryInterface extends ModelRepositoryInterface
{
}
