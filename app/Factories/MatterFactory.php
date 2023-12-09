<?php

declare(strict_types=1);

namespace App\Factories;

use App\Contracts\Factories\MatterFactoryInterface;
use App\Models\Matter;

final class MatterFactory implements MatterFactoryInterface
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
