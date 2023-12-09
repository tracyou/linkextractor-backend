<?php

declare(strict_types=1);

namespace App\Contracts\Factories;

use App\Models\Pancake;

interface PancakeFactoryInterface
{
    public function create(
        int $diameter
    ): Pancake;
}
