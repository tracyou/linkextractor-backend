<?php

namespace App\Contracts\Factories;

use App\Models\PancakeStack;

interface PancakeStackFactoryInterface
{
    /**
     * @param string $name
     * @return PancakeStack
     */
    public function create(
        string $name
    ): PancakeStack;
}
