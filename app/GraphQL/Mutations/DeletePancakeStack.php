<?php

namespace App\GraphQL\Mutations;

use App\Contracts\Repositories\PancakeStackRepositoryInterface;
use App\Models\PancakeStack;
use Exception;
use Illuminate\Contracts\Auth\Guard;

class DeletePancakeStack
{
    public function __construct(
        protected Guard $guard,
        protected PancakeStackRepositoryInterface $pancakeStackRepository,
    ) {
    }

    /**
     * @throws Exception
     */
    public function __invoke($_, array $args): bool
    {
        $id = $args['id'];

        /** @var PancakeStack $pancakeStack */
        $pancakeStack = $this->pancakeStackRepository->find($id);

        return $pancakeStack->delete();
    }
}
