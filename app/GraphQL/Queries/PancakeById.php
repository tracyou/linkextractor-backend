<?php

declare(strict_types=1);

namespace App\GraphQL\Queries;

use App\Contracts\Repositories\PancakeRepositoryInterface;
use App\Models\Pancake;

final class PancakeById
{
    public function __construct(
        protected PancakeRepositoryInterface $pancakeRepository,
    ) {
    }

    /** @param array<string, mixed> $args */
    public function __invoke(null $_, array $args): Pancake
    {
        $id = $args['id'];

        /** @var Pancake $pancake */
        $pancake = $this->pancakeRepository->find($id);

        return $pancake;
    }
}
