<?php

namespace App\Contracts\Factories;

use App\Models\Pancake;

interface PancakeFactoryInterface
{
    /**
     * @param int $diameter
     * @return Pancake
     */
    public function create(
        int $diameter
    ): Pancake;
}
