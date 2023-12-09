<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Contracts\Repositories\PancakeRepositoryInterface;
use App\Models\Pancake;
use Illuminate\Support\Collection;

final class Pancakes
{
    public function __construct(
        protected PancakeRepositoryInterface $pancakeRepository,
    ) {
    }

    /**
     * @param array<string, mixed> $args
     *
     * @return Collection<int, Pancake>
     */
    public function __invoke(null $_, array $args): Collection
    {
        return $this->pancakeRepository->all();
    }
}
