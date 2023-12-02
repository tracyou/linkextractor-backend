<?php

namespace App\GraphQL\Mutations;

use App\Contracts\Repositories\PancakeRepositoryInterface;
use App\Models\Pancake;
use Exception;
use Illuminate\Contracts\Auth\Guard;

class UpdatePancake
{
    public function __construct(
        protected Guard $guard,
        protected PancakeRepositoryInterface $pancakeRepository,
    ) {
    }

    /**
     * @throws Exception
     */
    public function __invoke($_, array $args): Pancake
    {
        $id = $args['id'];
        $diameter = $args['diameter'];

        /** @var Pancake $pancake */
        $pancake = $this->pancakeRepository->find($id);

        $pancake->diameter = $diameter;

        return $pancake;
    }
}
