<?php

declare(strict_types=1);

namespace Integration\Repositories;

use App\Contracts\Repositories\RelationSchemaRepositoryInterface;
use Tests\Http\GraphQL\AbstractHttpGraphQLTestCase;

class RelationSchemaRepositoryTest extends AbstractHttpGraphQLTestCase
{
    public RelationSchemaRepositoryInterface $repository;

    public function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->app->make(RelationSchemaRepositoryInterface::class);
    }
}
