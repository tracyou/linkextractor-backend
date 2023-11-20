<?php

namespace App\Factories;

use App\Contracts\Factories\PancakeFactoryInterface;
use App\Models\Pancake;

class PancakeFactory implements PancakeFactoryInterface
{
    public function create(int $diameter): Pancake
    {
        $pancake = new Pancake();
        $pancake->diameter = $diameter;
        $pancake->save();

        return $pancake;
    }
}
