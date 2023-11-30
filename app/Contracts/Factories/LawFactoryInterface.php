<?php

namespace App\Contracts\Factories;

use App\Models\Law;

interface LawFactoryInterface
{

    public function create(
        string $title,
        string $text,
        bool $is_published,
    ):Law;
}
