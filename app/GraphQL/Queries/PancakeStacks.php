<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Contracts\Repositories\PancakeStackRepositoryInterface;
use App\Models\PancakeStack;
use Illuminate\Support\Collection;

final class PancakeStacks
{
    public function __construct(
        protected PancakeStackRepositoryInterface $pancakeStackRepository,
    ) {
    }

    /**
     * @param array<string, mixed> $args
     *
     * @return Collection<int, PancakeStack>
     */
    public function __invoke(null $_, array $args): Collection
    {
        return $this->pancakeStackRepository->all();
    }
}
