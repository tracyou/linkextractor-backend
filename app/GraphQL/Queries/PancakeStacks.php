<?php

namespace App\GraphQL\Queries;

use App\Contracts\Repositories\PancakeStackRepositoryInterface;
use App\Models\PancakeStack;
use Illuminate\Support\Collection;

class PancakeStacks
{
    public function __construct(
        protected PancakeStackRepositoryInterface $pancakeStackRepository,
    ) {
    }

    /**
     * @param null $_
     * @param array<string, mixed> $args
     * @return Collection<int, PancakeStack>
     */
    public function __invoke(null $_, array $args): Collection
    {
        return $this->pancakeStackRepository->all();
    }
}
