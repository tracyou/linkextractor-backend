<?php

declare(strict_types=1);

namespace App\Contracts\Factories;

use App\Models\Matter;

interface MatterFactoryInterface
{
    public function create(string $name, string $color): Matter;

}
