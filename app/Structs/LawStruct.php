<?php

namespace App\Structs;

use App\Models\Law;
use Illuminate\Support\Arr;

final class LawStruct
{
    /** @param ArticleStruct[]  $articles */
    public function __construct(
        private string $title,
        private array $articles = [],
    ) {
    }

    public function add(ArticleStruct $article): void
    {
        $this->articles[] = $article;
    }

    public function remove(int $key): void
    {
        Arr::pull($this->articles, $key);
    }

    public function save(): void
    {
        $law = Law::firstOrCreate(['title' => $this->title]);
        foreach ($this->articles as $article) {
            $model = $article->toModel();
            $model?->law()->associate($law);
            $model?->save();
        }
    }
}
