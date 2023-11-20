<?php

namespace App\GraphQL\Mutations;

use App\Contracts\Repositories\PancakeRepositoryInterface;
use App\Models\Pancake;
use Exception;
use Illuminate\Contracts\Auth\Guard;

class DeletePancake
{
    public function __construct(
        protected Guard $guard,
        protected PancakeRepositoryInterface $pancakeRepository,
    ) {}

    /**
     * @throws Exception
     */
    public function __invoke($_, array $args): bool
    {
        $id = $args['id'];

        /** @var Pancake $pancake */
        $pancake = $this->pancakeRepository->find($id);

        return $pancake->delete();
    }
}
