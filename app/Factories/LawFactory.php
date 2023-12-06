<?php

namespace App\Factories;

use App\Contracts\Factories\LawFactoryInterface;
use App\Models\Law;

class LawFactory implements LawFactoryInterface
{
    public function create(string $title, string $text, bool $isPublished): Law
    {
        $law = new Law();
        $law->title = $title;
        $law->text = $text;
        $law->isPublished = $isPublished;

        $law->save();
        return $law;
    }
}
