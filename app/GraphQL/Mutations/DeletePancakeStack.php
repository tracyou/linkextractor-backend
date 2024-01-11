<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Contracts\Repositories\PancakeStackRepositoryInterface;
use App\Models\PancakeStack;
use Exception;
use Illuminate\Contracts\Auth\Guard;

final class DeletePancakeStack
{
    public function __construct(
        protected Guard $guard,
        protected PancakeStackRepositoryInterface $pancakeStackRepository,
    ) {
    }

    /**
     * @param array<mixed, mixed> $args
     *
     * @throws Exception
     */
    public function __invoke(null $_, array $args): bool
    {
        $id = $args['id'];

        /** @var PancakeStack $pancakeStack */
        $pancakeStack = $this->pancakeStackRepository->find($id);

        return (bool) $pancakeStack->delete();
    }
}
