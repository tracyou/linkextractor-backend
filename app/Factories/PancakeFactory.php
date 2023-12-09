<?php

declare(strict_types=1);

namespace App\Factories;

use App\Contracts\Factories\PancakeFactoryInterface;
use App\Models\Pancake;

final class PancakeFactory implements PancakeFactoryInterface
{
    public function create(int $diameter): Pancake
    {
        $pancake = new Pancake();
        $pancake->diameter = $diameter;
        $pancake->save();

        return $pancake;
    }
}
