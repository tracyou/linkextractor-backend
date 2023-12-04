<?php

namespace App\Factories;

use App\Models\Matter;

class MatterFactory
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
