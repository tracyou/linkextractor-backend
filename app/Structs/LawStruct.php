<?php

namespace App\Structs;

use App\Models\Law;

final class LawStruct
{
    public function __construct(
        public ?string $label = null,
        public ?string $nr = null,
        public ?string $titel = null,
        public ?string $text = null,
    )
    {
    }

    public function toModel(): ?Law
    {
        $law = new Law();
        $law->title = $this->label . ' ' . $this->nr . ' ' . $this->titel;
        if (! $this->text) {
            return null;
        }
        $law->text = $this->text;
        $law->is_published = false;

        return $law;
    }
}
