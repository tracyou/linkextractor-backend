<?php

namespace App\Factories;

use App\Contracts\Factories\PancakeStackFactoryInterface;
use App\Models\PancakeStack;

class PancakeStackFactory implements PancakeStackFactoryInterface
{

    public function create(string $name): PancakeStack
    {
        $pancakeStack = new PancakeStack();
        $pancakeStack->name = $name;
        $pancakeStack->save();

        return $pancakeStack;
    }
}
