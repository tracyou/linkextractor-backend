<?php

declare(strict_types=1);

namespace App\GraphQL\Mutations;

use App\Contracts\Factories\PancakeFactoryInterface;
use App\Models\Pancake;
use Exception;
use Illuminate\Contracts\Auth\Guard;

final class CreatePancake
{
    public function __construct(
        protected Guard $guard,
        protected PancakeFactoryInterface $pancakeFactory,
    ) {
    }

    /**
     * @param array<mixed, mixed> $args
     *
     * @throws Exception
     */
    public function __invoke(null $_, array $args): Pancake
    {
        $diameter = $args['diameter'];

        return $this->pancakeFactory->create($diameter);
    }
}
