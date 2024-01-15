<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Contracts\Factories\PancakeStackFactoryInterface;
use App\Contracts\Repositories\PancakeRepositoryInterface;
use App\Models\Pancake;
use App\Models\PancakeStack;
use Exception;
use Illuminate\Contracts\Auth\Guard;

final class CreatePancakeStack
{
    public function __construct(
        protected Guard $guard,
        protected PancakeStackFactoryInterface $pancakeStackFactory,
        protected PancakeRepositoryInterface $pancakeRepository,
    ) {
    }

    /**
     * @param array<mixed, mixed> $args
     *
     * @throws Exception
     */
    public function __invoke(null $_, array $args): PancakeStack
    {
        $name = $args['name'];

        /** @var array<int, string> $pancakeIds */
        $pancakeIds = $args['pancakes'];
        $pancakeIds = collect($pancakeIds)->map(fn (string $id) => (int) $id);

        $pancakeStack = $this->pancakeStackFactory->create($name);

        foreach ($pancakeIds as $pancakeId) {
            /** @var Pancake $pancake */
            $pancake = $this->pancakeRepository->find($pancakeId);
            $pancakeStack->addPancake($pancake);
        }

        return $pancakeStack;
    }
}
