<?php

namespace App\Structs;

use App\Models\Law;

final class LawBookStruct
{
    public function __construct(
        public ?int $lawBookNumber = null,
        public ?string $lawBookName = null,
        public ?string $label = null,
        public ?string $nr = null,
        public ?string $titel = null,
        public ?string $text = null,
    ) { }

    public function toModel(): Law
    {
        $law = new Law();
        $law->title = $this->label . $this->nr . $this->titel;
        $law->text = $this->text;
        $law->isPublished = false;

        return $law;
    }
}
