<?php

namespace App\Factories;

use App\Contracts\Factories\LawFactoryInterface;
use App\Models\Law;

class LawFactory implements LawFactoryInterface
{
    public function create(string $title, string $text, bool $is_published): Law
    {
        $law = new Law();
        $law->title = $title;
        $law->text = $text;
        $law->is_published = $is_published;

        $law->save();
        return $law;
    }
}
