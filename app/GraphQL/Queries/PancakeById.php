<?php

namespace App\GraphQL\Queries;

use App\Contracts\Repositories\PancakeRepositoryInterface;
use App\Models\Pancake;

class PancakeById
{
    public function __construct(
        protected PancakeRepositoryInterface $pancakeRepository,
    ) {
    }

    /**
     * @param null $_
     * @param array<string, mixed> $args
     * @return Pancake
     */
    public function __invoke(null $_, array $args): Pancake
    {
        $id = $args['id'];

        /** @var Pancake $pancake */
        $pancake = $this->pancakeRepository->find($id);

        return $pancake;
    }
}
