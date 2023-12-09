<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Contracts\Repositories\PancakeStackRepositoryInterface;
use App\Models\PancakeStack;

final class PancakeStackById
{
    public function __construct(
        protected PancakeStackRepositoryInterface $pancakeStackRepository,
    ) {
    }

    /** @param array<string, mixed> $args */
    public function __invoke(null $_, array $args): PancakeStack
    {
        $id = $args['id'];

        /** @var PancakeStack $pancakeStack */
        $pancakeStack = $this->pancakeStackRepository->find($id);

        return $pancakeStack;
    }
}
