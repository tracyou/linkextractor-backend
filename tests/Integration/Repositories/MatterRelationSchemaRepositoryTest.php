<?php

declare(strict_types=1);

namespace Integration\Repositories;

use App\Contracts\Repositories\MatterRelationSchemaRepositoryInterface;
use Tests\Http\GraphQL\AbstractHttpGraphQLTestCase;

class MatterRelationSchemaRepositoryTest extends AbstractHttpGraphQLTestCase
{
    public MatterRelationSchemaRepositoryInterface $repository;

    public function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->app->make(MatterRelationSchemaRepositoryInterface::class);
    }
}
