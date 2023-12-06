<?php

namespace App\Factories;

use App\Contracts\Factories\MatterFactoryInterface;
use App\Models\Matter;

class MatterFactory implements MatterFactoryInterface
{
    public function create(string $name, string $color): Matter
    {
        $matter = new Matter();
        $matter->name = $name;
        $matter->color = $color;

        $matter->save();
        return $matter;
    }
}
