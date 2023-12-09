<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Contracts\Repositories\PancakeRepositoryInterface;
use App\Contracts\Repositories\PancakeStackRepositoryInterface;
use App\Models\Pancake;
use App\Models\PancakeStack;
use Exception;
use Illuminate\Contracts\Auth\Guard;

final class UpdatePancakeStack
{
    public function __construct(
        protected Guard $guard,
        protected PancakeStackRepositoryInterface $pancakeStackRepository,
        protected PancakeRepositoryInterface $pancakeRepository,
    ) {
    }

    /**
     * @param array<mixed, mixed> $args
     *
     * @throws Exception
     */
    public function __invoke($_, array $args): PancakeStack
    {
        $id = $args['id'];
        $name = $args['name'];

        /** @var array<int, string> $pancakeIds */
        $pancakeIds = $args['pancakes'];
        $pancakeIds = collect($pancakeIds)->map(fn (string $id) => (int) $id);

        /** @var PancakeStack $pancakeStack */
        $pancakeStack = $this->pancakeStackRepository->find($id);

        $pancakeStack->name = $name;
        $pancakeStack->save();

        $pancakeStack->clearPancakes();

        foreach ($pancakeIds as $pancakeId) {
            /** @var Pancake $pancake */
            $pancake = $this->pancakeRepository->find($pancakeId);
            $pancake->stack()->dissociate();

            $pancakeStack->addPancake($pancake);
        }

        return $pancakeStack;
    }
}
