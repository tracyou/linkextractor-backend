<?php

declare(strict_types=1);

namespace App\Contracts\Factories;

use App\Models\PancakeStack;

interface PancakeStackFactoryInterface
{
    public function create(
        string $name
    ): PancakeStack;
}
