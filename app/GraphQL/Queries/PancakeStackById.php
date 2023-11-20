<?php

namespace App\GraphQL\Queries;

use App\Contracts\Repositories\PancakeStackRepositoryInterface;
use App\Models\PancakeStack;

class PancakeStackById
{
    public function __construct(
        protected PancakeStackRepositoryInterface $pancakeStackRepository,
    ) {
    }

    /**
     * @param null $_
     * @param array<string, mixed> $args
     * @return PancakeStack
     */
    public function __invoke(null $_, array $args): PancakeStack
    {
        $id = $args['id'];

        /** @var PancakeStack $pancakeStack */
        $pancakeStack = $this->pancakeStackRepository->find($id);

        return $pancakeStack;
    }
}
