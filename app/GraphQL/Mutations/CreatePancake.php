<?php

namespace App\GraphQL\Mutations;

use App\Contracts\Factories\PancakeFactoryInterface;
use App\Models\Pancake;
use Exception;
use Illuminate\Contracts\Auth\Guard;

class CreatePancake
{
    public function __construct(
        protected Guard $guard,
        protected PancakeFactoryInterface $pancakeFactory,
    ) {
    }

    /**
     * @throws Exception
     */
    public function __invoke($_, array $args): Pancake
    {
        $diameter = $args['diameter'];

        return $this->pancakeFactory->create($diameter);
    }
}
