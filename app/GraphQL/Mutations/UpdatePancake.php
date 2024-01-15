<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Contracts\Repositories\PancakeRepositoryInterface;
use App\Models\Pancake;
use Exception;
use Illuminate\Contracts\Auth\Guard;

final class UpdatePancake
{
    public function __construct(
        protected Guard $guard,
        protected PancakeRepositoryInterface $pancakeRepository,
    ) {
    }

    /**
     * @param array<mixed, mixed> $args
     *
     * @throws Exception
     */
    public function __invoke(null $_, array $args): Pancake
    {
        $id = $args['id'];
        $diameter = $args['diameter'];

        /** @var Pancake $pancake */
        $pancake = $this->pancakeRepository->find($id);

        $pancake->diameter = $diameter;

        return $pancake;
    }
}
