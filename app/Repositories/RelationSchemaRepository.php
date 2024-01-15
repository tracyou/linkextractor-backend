<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Repositories\RelationSchemaRepositoryInterface;
use App\Models\RelationSchema;
use Carbon\Carbon;
use Wimski\ModelRepositories\Repositories\AbstractModelRepository;

/**
 * @extends AbstractModelRepository<RelationSchema>
 */
class RelationSchemaRepository extends AbstractModelRepository implements RelationSchemaRepositoryInterface
{
    public function __construct(RelationSchema $model)
    {
        $this->model = $model;
    }

    public function expireAllExcept(string $id): bool|int
    {
        return $this->model->newQuery()
            ->where('id', '!=', $id)
            ->where('is_published', '=', true)
            ->update([
                'expired_at' => Carbon::now(),
            ]);
    }
}
