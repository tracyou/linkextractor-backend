<?php

declare(strict_types=1);

namespace App\Factories;

use App\Contracts\Factories\PancakeStackFactoryInterface;
use App\Models\PancakeStack;

final class PancakeStackFactory implements PancakeStackFactoryInterface
{
    public function create(string $name): PancakeStack
    {
        $pancakeStack = new PancakeStack();
        $pancakeStack->name = $name;
        $pancakeStack->save();

        return $pancakeStack;
    }
}
