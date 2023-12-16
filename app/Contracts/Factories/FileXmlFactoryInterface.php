<?php

namespace App\Contracts\Factories;

use App\Models\FileXml;

interface FileXmlFactoryInterface
{
    public function create(
        string $title,
        string $content,
    ): FileXml;
}
