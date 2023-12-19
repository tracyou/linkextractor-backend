<?php

declare(strict_types=1);

namespace App\Contracts\Factories;

use App\Models\Law;

interface LawFactoryInterface
{
    public function create(
        string $title,
        bool $isPublished,
    ): Law;
}
