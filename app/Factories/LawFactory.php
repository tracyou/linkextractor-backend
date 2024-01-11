<?php

declare(strict_types=1);

namespace App\Factories;

use App\Contracts\Factories\LawFactoryInterface;
use App\Models\Law;

final class LawFactory implements LawFactoryInterface
{
    public function create(string $title, string $text, bool $isPublished): Law
    {
        $law = new Law();
        $law->title = $title;
        $law->is_published = $isPublished;

        $law->save();

        return $law;
    }
}
