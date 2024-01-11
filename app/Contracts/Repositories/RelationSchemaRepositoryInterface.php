<?php

declare(strict_types=1);

namespace App\Contracts\Repositories;

use App\Models\RelationSchema;
use Wimski\ModelRepositories\Contracts\Repositories\ModelRepositoryInterface;

/**
 * @extends ModelRepositoryInterface<RelationSchema>
 */
interface RelationSchemaRepositoryInterface extends ModelRepositoryInterface
{
    /** This method expires all *PUBLISHED* schemas except the one with the given ID. */
    public function expireAllExcept(string $id): bool|int;
}
